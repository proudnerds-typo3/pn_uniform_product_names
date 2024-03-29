<?php

namespace Proudnerds\PnUniformProductNames\Controller;

use Proudnerds\PnUniformProductNames\Domain\Repository\PagesRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class UniformeproductnamenController
 * @package Proudnerds\PnUniformProductNames\Controller
 */
class UniformeproductnamenController extends ActionController
{
    /**
     * @var PagesRepository
     */
    protected $pagesRepository = null;

    /**
     * @param PagesRepository $pagesRepository
     */
    public function __construct(
        PagesRepository $pagesRepository
    ) {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * Set the output to XML
     */
    public function initializeShowAction()
    {
        $this->request->setFormat('xml');
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\DBALException
     */
    public function showAction() {
        $defaultExport = boolval($this->settings['defaultExport']);

        $pagesWithProductNames = $this->pagesRepository->findAllPagesWithProductNames($defaultExport);

        $this->view->assignMultiple([
            'pages' => $pagesWithProductNames
        ]);
    }
}

