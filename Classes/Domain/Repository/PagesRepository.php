<?php

namespace Proudnerds\PnUniformProductNames\Domain\Repository;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Site\SiteFinder;
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
    private const EXCLUDED_DOKTYPES = [
        PageRepository::DOKTYPE_LINK,
        PageRepository::DOKTYPE_SHORTCUT,
        PageRepository::DOKTYPE_BE_USER_SECTION,
        PageRepository::DOKTYPE_MOUNTPOINT,
        PageRepository::DOKTYPE_SPACER,
        PageRepository::DOKTYPE_SYSFOLDER,
    ];

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly SiteFinder $siteFinder
    ) {
        parent::__construct();
    }

    /**
     * findAllPagesWithProductNames
     *
     * @param bool $defaultExport
     * @param int $siteRootPageId Restrict to pages of this site; 0 returns every site
     *
     * @return array
     * @throws Exception
     */
    public function findAllPagesWithProductNames(bool $defaultExport, int $siteRootPageId = 0): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');

        $whereExpressions = [];
        $orWhereExpressions = [];

        if ($defaultExport) {
            // All pages will be exported except those with 'export' in page properties set on 'Nee'
            $whereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('1', Connection::PARAM_STR));
            $orWhereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('', Connection::PARAM_STR));
        } else {
            $whereExpressions[] = $queryBuilder->expr()->gt('uniform_product_names_uniforme_productnaam', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT));
            $orWhereExpressions[] = $queryBuilder->expr()->eq('uniform_product_names_export', $queryBuilder->createNamedParameter('1', Connection::PARAM_STR));
        }

        $pages = [];
        $statement = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(...$whereExpressions)
            ->orWhere(...$orWhereExpressions)
            ->andWhere(
                $queryBuilder->expr()->eq('sys_language_uid', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT)),
                $queryBuilder->expr()->notIn('doktype', $queryBuilder->createNamedParameter(self::EXCLUDED_DOKTYPES, Connection::PARAM_INT_ARRAY))
            )
            ->executeQuery();
        while ($row = $statement->fetchAssociative()) {
            if ($siteRootPageId > 0 && $this->getRootPageId((int)$row['uid']) !== $siteRootPageId) {
                continue;
            }
            $pages[] = $row;
        }

        return $pages;
    }

    private function getRootPageId(int $pageId): int
    {
        try {
            return $this->siteFinder->getSiteByPageId($pageId)->getRootPageId();
        } catch (SiteNotFoundException) {
            return 0;
        }
    }
}
