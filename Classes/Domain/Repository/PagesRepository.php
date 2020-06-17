<?php
namespace Proudnerds\PnUniformProductNames\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***
 *
 * This file is part of the "Uniform product names" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Jacco van der Post <jacco.vanderpost@proudnerds.com>, Proud Nerds
 *
 ***/
/**
 * The repository for Pages
 */
class PagesRepository extends Repository
{
    /**
     * findAllPagesWithProductNames
     *
     * @param bool $defaultExport
     *
     * @return array
     */
    public function findAllPagesWithProductNames(bool $defaultExport) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

        $whereExpressions = [];
        $orWhereExpressions = [];

        if ($defaultExport) {
            // All pages will be exported except those with 'export' in page properties set on 'Nee'
            $whereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('1', \PDO::PARAM_STR));
            $orWhereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('', \PDO::PARAM_STR));
        } else {
            $whereExpressions[] = $queryBuilder->expr()->gt('uniform_product_names_uniforme_productnaam', $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT));
            $orWhereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('1', \PDO::PARAM_STR));
        }

        $pages = [];
        $statement = $queryBuilder
            ->select('*')
            ->from ('pages')
            ->where(...$whereExpressions)
            ->orWhere(...$orWhereExpressions)
            ->execute();
        while ($row = $statement->fetch()) {
            $pages[] = $row;
        }

        return $pages;
    }
}
