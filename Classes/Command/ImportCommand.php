<?php

namespace Proudnerds\PnUniformProductNames\Command;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen;
use Proudnerds\PnUniformProductNames\Domain\Repository\UniformeproductnamenRepository;
use Proudnerds\PnUniformProductNames\Utility\Typo3Utility;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class ImportCommand
 *
 * Imports and updates Uniform Product Names
 *
 * 2020 Jacco van der Post <jacco.vanderpost@proudnerds.com>, Proud Nerds
 */

/**
 * Class ImportCommand
 */
class ImportCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var UniformeproductnamenRepository
     */
    protected $uniformeproductnamenRepository;

    protected PersistenceManager $persistenceManager;

    public function __construct(
        UniformeproductnamenRepository $uniformeproductnamenRepository,
        PersistenceManager $persistenceManager,
        private readonly SiteFinder $siteFinder
    ) {
        parent::__construct();
        $this->uniformeproductnamenRepository = $uniformeproductnamenRepository;
        $this->persistenceManager = $persistenceManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Imports UPL productnames.')
            ->setHelp('This command imports productnames from the Uniforme Productenlijst...')
            ->addOption(
                'page',
                'p',
                InputOption::VALUE_REQUIRED,
                'Page uid whose TypoScript holds the settings and on which the records are stored. Defaults to the lowest site root page uid.',
                0
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing productnames to database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Exception
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $folderDirectory = Environment::getPublicPath() . '/typo3temp/pn_uniform_product_names/';
        if (!@is_dir($folderDirectory)) {
            GeneralUtility::mkdir_deep($folderDirectory);
        }
        $io = new SymfonyStyle($input, $output);

        $pageId = $this->resolvePageId($input);
        $io->text(['Reading settings and storing records for page uid ' . $pageId]);

        $settings = Typo3Utility::getSettings('pnuniformproductnames', $pageId);
        $url = trim((string)($settings['sourceXmlUrl'] ?? ''));
        if ($url === '') {
            $logMessage = 'No sourceXmlUrl configured in plugin.tx_pnuniformproductnames.settings. '
                . 'Use --page=<uid> to point at a page whose TypoScript template includes this extension.';
            $io->error($logMessage);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            return Command::FAILURE;
        }

        $date = new \DateTime();
        $productNamesTempImportFilePath = $folderDirectory . 'UPL_import_' . $date->format('H-i-s_d-m-Y') . '.xml';

        $client = new Client();

        $logMessage = 'Making request to get ' . $url;
        $io->text(['', $logMessage]);
        $this->logger->log(LogLevel::INFO, $logMessage);

        // Save XML file
        try {
            $response = $client->request('GET', $url, [
                'sink' => $productNamesTempImportFilePath,
                'headers' => ['Cache-Control' => 'no-cache'],
                'allow_redirects' => false,
            ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $error = 'URL : ' . $url . PHP_EOL;
            $error .= 'HTTP status code: ' . $response->getStatusCode() . PHP_EOL;
            $error .= 'Response message: ' . $response->getReasonPhrase() . PHP_EOL;

            $body = trim((string)$response->getBody());
            if ($body !== '') {
                $error .= 'Body: ' . mb_substr($body, 0, 2000) . PHP_EOL;
            }

            $headers = $response->getHeaders();
            $headers = implode('&', array_map(function ($a) {
                return implode('~', $a);
            }, $headers));
            $error .= 'Headers: ' . $headers . PHP_EOL;
            $error .= 'Content-Type: ' . ($response->getHeaderLine('Content-Type') ?: '(none)') . PHP_EOL . PHP_EOL;

            $io->text(['', $error]);
            $this->logger->log(LogLevel::CRITICAL, $error);
            Typo3Utility::flashmessage($error, '', ContextualFeedbackSeverity::ERROR);
            return Command::FAILURE;
        } catch (\Exception $e) {
            $logMessage = 'Unknown error, no response from ' . $url . PHP_EOL . $e->getCode() . PHP_EOL . $e->getMessage();
            $io->text(['', $logMessage]);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            Typo3Utility::flashmessage($logMessage, '', ContextualFeedbackSeverity::ERROR);
            return Command::FAILURE;
        }

        $responseCode = $response->getStatusCode();

        $io->text(['Response code: ' . $responseCode]);

        if ($responseCode !== 200) {
            $logMessage = 'Expected HTTP 200 from ' . $url . ', got ' . $responseCode . ' ' . $response->getReasonPhrase();
            $io->text(['', $logMessage]);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            Typo3Utility::flashmessage($logMessage, '', ContextualFeedbackSeverity::ERROR);
            $this->removeFile($productNamesTempImportFilePath);
            return Command::FAILURE;
        }

        $io->text(['Succes! File is retrieved and saved at ' . $productNamesTempImportFilePath]);

        // Store XML file content in an array
        try {
            $xml = simplexml_load_string((string)file_get_contents($productNamesTempImportFilePath));
            $json = json_encode($xml);
            $productNames = is_string($json) ? json_decode($json, true) : null;

            $results = is_array($productNames) ? ($productNames['results']['result'] ?? null) : null;
            if (is_array($results) && !array_is_list($results)) {
                $results = [$results];
            }

            if (!is_array($results) || $results === []) {
                $logMessage = 'Something went wrong when reading the XML file ' . $productNamesTempImportFilePath;
                $io->text(['', $logMessage]);
                $this->logger->log(LogLevel::CRITICAL, $logMessage);
                Typo3Utility::flashmessage($logMessage, '', ContextualFeedbackSeverity::ERROR);
                $this->removeFile($productNamesTempImportFilePath);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $logMessage = $e->getMessage();
            $io->text([
                '',
                'Something went wrong when reading the XML file ' . $productNamesTempImportFilePath . ': ' . $logMessage,
            ]);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            Typo3Utility::flashmessage($logMessage, '', ContextualFeedbackSeverity::ERROR);
            $this->removeFile($productNamesTempImportFilePath);
            return Command::FAILURE;
        }

        // Process the new productNames and store in database
        $numberOfProductNames = 0;
        $numberOfNewProductNames = 0;

        $knownTitles = [];
        foreach ($this->uniformeproductnamenRepository->findAll() as $storedProductName) {
            $knownTitles[$storedProductName->getTitle()] = true;
        }

        foreach ($results as $result) {
            $numberOfProductNames++;
            $productName = new Uniformeproductnamen();
            $validProductName = false;

            foreach (($result['binding'] ?? []) as $binding) {
                $bindingName = $binding['@attributes']['name'] ?? '';

                if ($bindingName === 'UniformeProductnaam' && !empty($binding['literal'])) {
                    $productName->setTitle($binding['literal']);
                    $validProductName = true;
                }

                if ($bindingName === 'URI' && !empty($binding['uri'])) {
                    $productName->setUri($binding['uri']);
                }
            }

            // A productname occurs multiple times in the feed, once per Grondslaglabel. Those labels
            // are not used here, so only the first occurrence is stored.
            if ($validProductName && !isset($knownTitles[$productName->getTitle()])) {
                $this->uniformeproductnamenRepository->add($productName);
                $knownTitles[$productName->getTitle()] = true;
                $numberOfNewProductNames++;
            }
        }

        $this->persistenceManager->persistAll();
        $this->removeFile($productNamesTempImportFilePath);

        $logMessage = 'Import of uniform product names finished. ' . $numberOfProductNames . ' items have been processed, ' . $numberOfNewProductNames . ' new productnames are added to the database in tx_pnuniformproductnames_domain_model_uniformeproductnamen';
        $io->text(['', $logMessage]);
        $this->logger->log(LogLevel::INFO, $logMessage);
        Typo3Utility::flashmessage($logMessage);

        return Command::SUCCESS;
    }

    private function resolvePageId(InputInterface $input): int
    {
        $pageId = (int)$input->getOption('page');
        if ($pageId > 0) {
            return $pageId;
        }

        $rootPageIds = array_map(
            static fn($site) => $site->getRootPageId(),
            array_values($this->siteFinder->getAllSites())
        );

        return $rootPageIds === [] ? 0 : min($rootPageIds);
    }

    private function removeFile(string $filePath): void
    {
        if (is_file($filePath)) {
            @unlink($filePath);
        }
    }
}
