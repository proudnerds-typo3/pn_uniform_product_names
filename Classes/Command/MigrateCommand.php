<?php

namespace Proudnerds\PnUniformProductNames\Command;

use Exception;
use Proudnerds\PnUniformProductNames\Utility\Typo3Utility;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class MigrateCommand
 *
 * Migrates Uniform Product Names values in pages table from alternet_sc_pages to pn_uniform_product_names
 * The import command needs to be ran once beforehand and of course alternet_sc_pages 5.0.0 needs to be installed
 *
 * Should only be needed to run once
 *
 * 2020 Jacco van der Post <jacco.vanderpost@proudnerds.com>, Proud Nerds
 *
 * @package Proudnerds\PnUniformProductNames\Command
 *
 * Run in console (with correct context):
 * TYPO3_CONTEXT=Development/local php  ./vendor/bin/typo3 PnUniformProductNames:migrate
 *
 * Add in TYPO3 scheduler via:
 * Execute console commands
 *
 */

/**
 * Class MigrateCommand
 * @package Proudnerds\PnUniformProductNames\Command
 */
class MigrateCommand extends Command
{
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
        $this->setDescription('Migrate UPL productnames.')
            ->setHelp('This command migrates productnames page properties from alternet_sc_pages to pn_uniform_product_names...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Migrating productnames page properties');
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
        $io = new SymfonyStyle($input, $output);
        $settings = Typo3Utility::getSettings();
        $projectRootPath = GeneralUtility::fixWindowsFilePath(getenv('TYPO3_PATH_APP'));
        $date = new \DateTime();
        $migrateMissingCsvFile = fopen($projectRootPath . '/public/typo3temp/pn_uniform_product_names/UPL_migrate_' . $date->format('H-i-s_d-m-Y') . '.csv',
            'w');

        $logMessage = 'Migrating start..';
        $io->text(['', $logMessage]);
        fputcsv($migrateMissingCsvFile, ['Pages with non existing productnames']);
        fputcsv($migrateMissingCsvFile,
            ['Page Uid', 'Page title', 'Outdated productname', 'Outdated related productname']);

        $numberOfProductNames = 0;
        $pages = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

        $queryBuilder
            ->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $statement = $queryBuilder
            ->select('*')
            ->from('pages')
            ->execute();
        while ($row = $statement->fetch()) {
            $pages[] = $row;
        }

        $logMessage = 'Processing ' . count($pages) . ' pages..';
        $io->text(['', $logMessage]);

        $progress = new ProgressBar($output, count($pages));
        $progress->start();

        foreach ($pages as $page) {
            $progress->advance();

            if ($page['tx_alternetscpages_doelgroep']) {
                $queryBuilder->resetQueryParts();

                if ($page['tx_alternetscpages_doelgroep'] === 'organisatie/ondernemer') {
                    $page['uniform_product_names_audience'] = 'ondernemer';
                } else {
                    $page['uniform_product_names_audience'] = $page['tx_alternetscpages_doelgroep'];
                }

                $queryBuilder
                    ->update('pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->set('uniform_product_names_audience', $page['uniform_product_names_audience'])
                    ->execute();
            }


            $page['uniform_product_names_online_aanvragen'] = 'nee';
            if ($page['tx_alternetscpages_onlineaanvragen']) {
                $page['uniform_product_names_online_aanvragen'] = $page['tx_alternetscpages_onlineaanvragen'];
            }

            $queryBuilder->resetQueryParts();
            $queryBuilder
                ->update('pages')
                ->where(
                    $queryBuilder->expr()->eq('uid',
                        $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                )
                ->set('uniform_product_names_online_aanvragen', $page['uniform_product_names_online_aanvragen'])
                ->execute();


            if ($page['tx_alternetscpages_aanvraagurl']) {
                $page['uniform_product_names_aanvraag_url'] = $page['tx_alternetscpages_aanvraagurl'];

                $queryBuilder->resetQueryParts();
                $queryBuilder
                    ->update('pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->set('uniform_product_names_aanvraag_url', $page['uniform_product_names_aanvraag_url'])
                    ->execute();
            }


            if ($page['tx_alternetscpages_productnaam']) {
                $numberOfProductNames++;
                $page['uniform_product_names_abstract'] = $page['tx_alternetscpages_productnaam'];

                $queryBuilder->resetQueryParts();
                $queryBuilder
                    ->update('pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->set('uniform_product_names_abstract', $page['uniform_product_names_abstract'])
                    ->execute();
            }


            if ($page['tx_alternetscpages_taal']) {
                $page['uniform_product_names_language'] = $page['tx_alternetscpages_taal'];

                $queryBuilder->resetQueryParts();
                $queryBuilder
                    ->update('pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->set('uniform_product_names_language', $page['uniform_product_names_language'])
                    ->execute();
            }


            if ($page['tx_alternetscpages_uniformeproductnaam']) {
                // Get the uid's of the alternet uniform productnames
                $alternetUniformNameUids = [];
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_alternetscpages_uniformeproductnaam_mm_pages');

                $statement = $queryBuilder
                    ->select('*')
                    ->from('tx_alternetscpages_uniformeproductnaam_mm_pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid_local',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('field',
                            $queryBuilder->createNamedParameter('uniform', \PDO::PARAM_STR))
                    )
                    ->execute();
                while ($row = $statement->fetch()) {
                    $alternetUniformNameUids[] = $row['uid_foreign'];
                }

                $alternetUniformNames = [];

                if ($alternetUniformNameUids) {
                    // Get the names of the alternet uniform productnames
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_alternetscpages_uniformeproductnaam');

                    $statement = $queryBuilder
                        ->select('*')
                        ->from('tx_alternetscpages_uniformeproductnaam')
                        ->where(
                            $queryBuilder->expr()->in('uid',
                                $queryBuilder->createNamedParameter($alternetUniformNameUids,
                                    Connection::PARAM_INT_ARRAY))
                        )
                        ->execute();
                    while ($row = $statement->fetch()) {
                        $alternetUniformNames[] = $row['name'];
                    }
                }

                $productNameUidsToAdd = [];

                foreach ($alternetUniformNames as $alternetUniformName) {
                    /** @var \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNameObject */
                    $uniformProductNameObject = $this->getUniformeproductnamenRepository()->findByTitle($alternetUniformName);

                    if (Typo3Utility::emptyObj($uniformProductNameObject)) {
                        // The productname from Alternet does not exist (anymore) in the new productnames
                        // Log it in typo3temp/pn_uniform_product_names/UPL_migrate_xx.csv
                        $csvEntry = [$page['uid'], $page['title'], $alternetUniformName, ''];
                        fputcsv($migrateMissingCsvFile, $csvEntry);
                        $logMessage = 'Page ' . $page['uid'] . ' ' . $page['title'] . ' has non existing productname: ' . $alternetUniformName;
                        $io->text(['', $logMessage]);
                    } else {
                        $productNameUidsToAdd[] = $uniformProductNameObject[0]->getUid();
                    }
                }

                // Add the uniform productnames to the page
                if ($productNameUidsToAdd) {
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

                    $queryBuilder
                        ->update('pages')
                        ->where(
                            $queryBuilder->expr()->eq('uid',
                                $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                        )
                        ->set('uniform_product_names_uniforme_productnaam', implode(',', $productNameUidsToAdd))
                        ->execute();
                }
            }


            if ($page['tx_alternetscpages_gerelateerd']) {
                // Get the uid's of the alternet uniform productnames
                $alternetUniformNameUids = [];
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_alternetscpages_uniformeproductnaam_mm_pages');

                $statement = $queryBuilder
                    ->select('*')
                    ->from('tx_alternetscpages_uniformeproductnaam_mm_pages')
                    ->where(
                        $queryBuilder->expr()->eq('uid_local',
                            $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                    )
                    ->andWhere(
                        $queryBuilder->expr()->eq('field',
                            $queryBuilder->createNamedParameter('related', \PDO::PARAM_STR))
                    )
                    ->execute();
                while ($row = $statement->fetch()) {
                    $alternetUniformNameUids[] = $row['uid_foreign'];
                }

                $alternetUniformNames = [];

                if ($alternetUniformNameUids) {
                    // Get the names of the alternet uniform productnames
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_alternetscpages_uniformeproductnaam');

                    $statement = $queryBuilder
                        ->select('*')
                        ->from('tx_alternetscpages_uniformeproductnaam')
                        ->where(
                            $queryBuilder->expr()->in('uid',
                                $queryBuilder->createNamedParameter($alternetUniformNameUids,
                                    Connection::PARAM_INT_ARRAY))
                        )
                        ->execute();
                    while ($row = $statement->fetch()) {
                        $alternetUniformNames[] = $row['name'];
                    }
                }

                $productNameUidsToAdd = [];

                foreach ($alternetUniformNames as $alternetUniformName) {
                    /** @var \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNameObject */
                    $uniformProductNameObject = $this->getUniformeproductnamenRepository()->findByTitle($alternetUniformName);

                    if (Typo3Utility::emptyObj($uniformProductNameObject)) {
                        // The related productname from Alternet does not exist (anymore) in the new productnames
                        // Log it in typo3temp/pn_uniform_product_names/UPL_migrate_xx.csv
                        $csvEntry = [$page['uid'], $page['title'], '', $alternetUniformName];
                        fputcsv($migrateMissingCsvFile, $csvEntry);
                        $logMessage = 'Page ' . $page['uid'] . ' ' . $page['title'] . ' has non existing related productname: ' . $alternetUniformName;
                        $io->text(['', $logMessage]);
                    } else {
                        $productNameUidsToAdd[] = $uniformProductNameObject[0]->getUid();
                    }
                }

                // Add the related uniform productnames to the page
                if ($productNameUidsToAdd) {
                    $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

                    $queryBuilder
                        ->update('pages')
                        ->where(
                            $queryBuilder->expr()->eq('uid',
                                $queryBuilder->createNamedParameter($page['uid'], \PDO::PARAM_INT))
                        )
                        ->set('uniform_product_names_gerelateerd_product', implode(',', $productNameUidsToAdd))
                        ->execute();
                }
            }
        }

        fclose($migrateMissingCsvFile);

        $progress->finish();
        $logMessage = 'Migration finished. ' . count($pages) . ' pages have been processed, ' . $numberOfProductNames . ' sets of productnames are migrated in the pages table';
        $io->text(['', $logMessage]);
        Typo3Utility::flashmessage($logMessage);
    }
}
