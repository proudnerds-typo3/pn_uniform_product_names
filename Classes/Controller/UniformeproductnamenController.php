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
     * pagesRepository
     *
     * @var PagesRepository
     */
    protected $pagesRepository = null;

    /**
     * @param PagesRepository $pagesRepository
     */
    public function injectPagesRepository(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }

    /**
     * Set the output to XML
     */
    public function initializeShowAction()
    {
        $this->request->setFormat('xml');
    }

    public function showAction() {
        $pagesWithProductNames = $this->pagesRepository->findAllPagesWithProductNames();

        $this->view->assignMultiple([
            'pages' => $pagesWithProductNames
        ]);
    }
}

