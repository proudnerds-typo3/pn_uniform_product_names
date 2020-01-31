<?php

namespace Proudnerds\PnUniformProductNames\ViewHelpers;

use Proudnerds\PnUniformProductNames\Domain\Repository\UniformeproductnamenRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class GetProductNamesViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var ObjectManagerInterface
     */
    protected static $objectManager;

    /**
     * uniformeproductnamenRepository
     *
     * @var UniformeproductnamenRepository
     */
    protected static $uniformeproductnamenRepository;

    /**
     * @return UniformeproductnamenRepository
     */
    protected static function getUniformeproductnamenRepository()
    {
        if (static::$uniformeproductnamenRepository === null) {
            static::$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            static::$uniformeproductnamenRepository = static::$objectManager->get('Proudnerds\\PnUniformProductNames\\Domain\Repository\\UniformeproductnamenRepository');
        }
        return static::$uniformeproductnamenRepository;
    }

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('uids', 'string', 'String with comma seperated uids', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return array|mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $uids = explode(',', $arguments['uids']);
        $productNames = [];
        foreach($uids as $uid) {
            $uid = (int)$uid;
            if ($uid > 0) {
                /** @var \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $product */
                $product = static::getUniformeproductnamenRepository()->findByUid($uid);
                if (is_a($product, 'Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen')) {
                    $productNames[] = $product;
                }
            }
        }
        return $productNames;
    }
}
