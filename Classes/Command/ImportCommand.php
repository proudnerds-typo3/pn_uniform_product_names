<?php

namespace Proudnerds\PnUniformProductNames\Command;

use Exception;
use Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen;
use Proudnerds\PnUniformProductNames\Utility\Typo3Utility;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class ImportCommand
 *
 * Imports and updates Uniform Product Names
 *
 * 2020 Jacco van der Post <jacco.vanderpost@proudnerds.com>, Proud Nerds
 *
 * @package Proudnerds\PnUniformProductNames\Command
 *
 * Run in console (with correct context):
 * TYPO3_CONTEXT=Development/local php  ./vendor/bin/typo3 PnUniformProductNames:import
 *
 * Add in TYPO3 scheduler via:
 * Execute console commands
 *
 */

/**
 * Class ImportCommand
 * @package Proudnerds\PnUniformProductNames\Command
 */
class ImportCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * uniformeproductnamenRepository
     *
     * @var \Proudnerds\PnUniformProductNames\Domain\Repository\UniformeproductnamenRepository
     */
    protected $uniformeproductnamenRepository;

    /**
     * @return \Proudnerds\PnUniformProductNames\Domain\Repository\UniformeproductnamenRepository
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    protected function getUniformeproductnamenRepository()
    {
        if ($this->uniformeproductnamenRepository === null) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->uniformeproductnamenRepository = $this->objectManager->get('Proudnerds\\PnUniformProductNames\\Domain\Repository\\UniformeproductnamenRepository');
        }
        return $this->uniformeproductnamenRepository;
    }

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Get Persistence Manager on demand
     *
     * @return PersistenceManager
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    protected function getPersistenceManager()
    {
        if (null === $this->persistenceManager) {
            $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        }
        return $this->persistenceManager;
    }

    protected function configure()
    {
        $this->setDescription('Imports UPL productnames.')
            ->setHelp('This command imports productnames from the Uniforme Productenlijst...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Importing productnames to database');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectRootPath = GeneralUtility::fixWindowsFilePath(getenv('TYPO3_PATH_APP'));
        $folderName = '/public/typo3temp/pn_uniform_product_names/';
        $folderDirectory = $projectRootPath . $folderName;
        if (!@is_dir($folderDirectory)) {
            GeneralUtility::mkdir_deep($folderDirectory);
        }
        $io = new SymfonyStyle($input, $output);
        $settings = Typo3Utility::getSettings();
        $url = $settings['sourceXmlUrl'];

        $date = new \DateTime();
        $productNamesTempImportFilePath = $folderDirectory . 'UPL_import_' . $date->format('H-i-s_d-m-Y') . '.xml';

        $additionalOptions = [
            'headers' => ['Cache-Control' => 'no-cache'],
            'allow_redirects' => false,
            'save_to' => $productNamesTempImportFilePath
        ];

        $logMessage = 'Making request to get ' . $url;
        $io->text(['', $logMessage]);
        $this->logger->log(LogLevel::INFO, $logMessage);

        /** @var RequestFactory $requestFactory */
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

        // Save XML file
        try {
            $response = $requestFactory->request($url, 'GET', $additionalOptions);
        } catch (
        \Exception $e
        ) {
            $response = $e->getMessage();
            $logMessage = $response;
            $io->text(['', $logMessage]);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            Typo3Utility::flashmessage($logMessage, '', FlashMessage::ERROR);
            return 0;
        }

        $responseCode = $response->getStatusCode();

        $io->text(['Response code: ' . $response->getStatusCode()]);

        if ($responseCode === 200) {
            $io->text(['Succes! File is retrieved and saved at ' . $productNamesTempImportFilePath]);
        }

        // Store XML file content in an array
        try {
            $xml = simplexml_load_string(file_get_contents($productNamesTempImportFilePath));
            $json = json_encode($xml);
            $productNames = json_decode($json, true);

            $arrayHasContent = false;
            if ($productNames['results']) {
                if ($productNames['results']['result']) {
                    $arrayHasContent = true;
                }
            }

            if (!$arrayHasContent) {
                $logMessage = 'Something went wrong when reading the XML file ' . $productNamesTempImportFilePath;
                $io->text(['', $logMessage]);
                $this->logger->log(LogLevel::CRITICAL, $logMessage);
                Typo3Utility::flashmessage($logMessage, '', FlashMessage::ERROR);
                return 0;
            }
        } catch (
        \Exception $e
        ) {
            $response = $e->getMessage();
            $logMessage = $response;
            $io->text([
                '',
                'Something went wrong when reading the XML file ' . $productNamesTempImportFilePath . ': ' . $logMessage
            ]);
            $this->logger->log(LogLevel::CRITICAL, $logMessage);
            Typo3Utility::flashmessage($logMessage, '', FlashMessage::ERROR);
            return 0;
        }

        // Process the new productNames and store in database
        $numberOfProductNames = 0;
        $numberOfNewProductNames = 0;

        $progress = new ProgressBar($output, count($productNames['results']['result']));
        $progress->start();

        foreach ($productNames['results']['result'] as $result) {

            // Look at the debug info of the array in TYPO3 backend Scheduler task to see the structure
            //Debug($result);

            $numberOfProductNames++;
            $progress->advance();
            $productName = new Uniformeproductnamen;
            $validProductName = false;

            foreach ($result['binding'] as $binding) {
                if ($binding['@attributes']['name'] === 'UniformeProductnaam') {
                    if ($binding['literal']) {
                        $productName->setTitle($binding['literal']);
                        $validProductName = true;
                    }
                }

                if ($binding['@attributes']['name'] === 'URI') {
                    if ($binding['uri']) {
                        $productName->setUri($binding['uri']);
                    }
                }
            }

            if ($validProductName) {
                // A productname could be multiple times in the XML, for example with different Grondslaglabels
                // These are however not used, so we keep only 1 version of the productname
                // Also dont insert already stored productnames
                if (Typo3Utility::emptyObj($this->getUniformeproductnamenRepository()->findByTitle($productName->getTitle()))) {
                    $this->getUniformeproductnamenRepository()->add($productName);
                    $this->getPersistenceManager()->persistAll();
                    $numberOfNewProductNames++;
                }
            }
        }

        $progress->finish();
        $logMessage = 'Import of uniform product names finished. ' . $numberOfProductNames . ' items have been processed, ' . $numberOfNewProductNames . ' new productnames are added to the database in tx_pnuniformproductnames_domain_model_uniformeproductnamen';
        $io->text(['', $logMessage]);
        $this->logger->log(LogLevel::INFO, $logMessage);
        Typo3Utility::flashmessage($logMessage);

        return 0;
    }
}