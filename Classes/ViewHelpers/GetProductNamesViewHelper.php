<?php

namespace Proudnerds\PnUniformProductNames\ViewHelpers;

use Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen;
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

    public function __construct(UniformeproductnamenRepository $uniformeproductnamenRepository)
    {
        $this->uniformeproductnamenRepository = $uniformeproductnamenRepository;
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments(): void
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
        foreach ($uids as $uid) {
            $uid = (int)$uid;
            if ($uid > 0) {
                $product = $this->uniformeproductnamenRepository->findByUid($uid);
                if ($product instanceof Uniformeproductnamen) {
                    $productNames[] = $product;
                }
            }
        }
        return $productNames;
    }
}
