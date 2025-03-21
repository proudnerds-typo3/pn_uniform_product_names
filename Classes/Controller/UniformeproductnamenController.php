<?php

namespace Proudnerds\PnUniformProductNames\Controller;

use Proudnerds\PnUniformProductNames\Domain\Repository\PagesRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class UniformeproductnamenController
 */
class UniformeproductnamenController extends ActionController
{
    protected PagesRepository $pagesRepository;

    public function __construct(
        PagesRepository $pagesRepository
    ) {
        $this->pagesRepository = $pagesRepository;
    }

    public function initializeAction(): void
    {
        $this->request = $this->request->withFormat('xml');
    }

    /**
     * @return ResponseInterface
     * @throws \Doctrine\DBAL\Exception
     */
    public function showAction(): ResponseInterface
    {
        $defaultExport = (bool)($this->settings['defaultExport']);

        $pagesWithProductNames = $this->pagesRepository->findAllPagesWithProductNames($defaultExport);

        $this->view->assignMultiple([
            'pages' => $pagesWithProductNames,
        ]);

        return $this->responseFactory
            ->createResponse()
            ->withHeader('Content-Type', 'application/xml; charset=utf-8')
            ->withBody($this->streamFactory->createStream($this->view->render()));
    }
}
