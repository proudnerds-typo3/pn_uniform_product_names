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
     * @return array
     */
    public function findAllPagesWithProductNames() {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');

        $pages = [];
        $statement = $queryBuilder
            ->select('*')
            ->from ('pages')
            ->where(
                $queryBuilder->expr()->gt('uniform_product_names_uniforme_productnaam',
                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT))
            )
            ->execute();
        while ($row = $statement->fetch()) {
            $pages[] = $row;
        }

        return $pages;
    }
}
