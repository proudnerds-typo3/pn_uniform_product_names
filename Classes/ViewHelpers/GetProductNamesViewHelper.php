<?php

namespace Proudnerds\PnUniformProductNames\ViewHelpers;

use Proudnerds\PnUniformProductNames\Domain\Repository\UniformeproductnamenRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetProductNamesViewHelper extends AbstractViewHelper
{
    /**
     * uniformeproductnamenRepository
     *
     * @var UniformeproductnamenRepository
     */
    protected $uniformeproductnamenRepository;

    /**
     * Inject Uniformeproductnamen Repository to enable DI
     *
     * @param UniformeproductnamenRepository $uniformeproductnamenRepository
     */
    public function injectUniformeproductnamenRepository(UniformeproductnamenRepository $uniformeproductnamenRepository)
    {
        $this->uniformeproductnamenRepository = $uniformeproductnamenRepository;
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('uids', 'string', 'String with comma seperated uids', true);
    }

    /**
     * @return array|mixed
     */
    public function render(
    ) {
        $uids = explode(',', $this->arguments['uids']);
        $productNames = [];
        foreach($uids as $uid) {
            $uid = (int)$uid;
            if ($uid > 0) {
                /** @var \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $product */
                $product = $this->uniformeproductnamenRepository->findByUid($uid);
                if (is_a($product, 'Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen')) {
                    $productNames[] = $product;
                }
            }
        }
        return $productNames;
    }
}
