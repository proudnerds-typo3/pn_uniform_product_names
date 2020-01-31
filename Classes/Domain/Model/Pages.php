<?php
namespace Proudnerds\PnUniformProductNames\Domain\Model;


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
 * Pages
 */
class Pages extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * uniformProductNamesAudience
     * 
     * @var string
     */
    protected $uniformProductNamesAudience = '';

    /**
     * uniformProductNamesOnlineAanvragen
     * 
     * @var string
     */
    protected $uniformProductNamesOnlineAanvragen = '';

    /**
     * uniformProductNamesAanvraagUrl
     * 
     * @var string
     */
    protected $uniformProductNamesAanvraagUrl = '';

    /**
     * uniformProductNamesAbstract
     *
     * @var string
     */
    protected $uniformProductNamesAbstract = '';

    /**
     * uniformProductNamesProductHtml
     *
     * @var string
     */
    protected $uniformProductNamesProductHtml = '';

    /**
     * uniformProductNamesLanguage
     *
     * @var string
     */
    protected $uniformProductNamesLanguage = '';

    /**
     * uniformProductNamesUniformeProductnaam
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $uniformProductNamesUniformeProductnaam = null;

    /**
     * uniformProductNamesGerelateerdProduct
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $uniformProductNamesGerelateerdProduct = null;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->uniformProductNamesUniformeProductnaam = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->uniformProductNamesGerelateerdProduct = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the uniformProductNamesAudience
     * 
     * @return string $uniformProductNamesAudience
     */
    public function getUniformProductNamesAudience()
    {
        return $this->uniformProductNamesAudience;
    }

    /**
     * Sets the uniformProductNamesAudience
     * 
     * @param string $uniformProductNamesAudience
     * @return void
     */
    public function setUniformProductNamesAudience($uniformProductNamesAudience)
    {
        $this->uniformProductNamesAudience = $uniformProductNamesAudience;
    }

    /**
     * Returns the uniformProductNamesOnlineAanvragen
     * 
     * @return string $uniformProductNamesOnlineAanvragen
     */
    public function getUniformProductNamesOnlineAanvragen()
    {
        return $this->uniformProductNamesOnlineAanvragen;
    }

    /**
     * Sets the uniformProductNamesOnlineAanvragen
     * 
     * @param string $uniformProductNamesOnlineAanvragen
     * @return void
     */
    public function setUniformProductNamesOnlineAanvragen($uniformProductNamesOnlineAanvragen)
    {
        $this->uniformProductNamesOnlineAanvragen = $uniformProductNamesOnlineAanvragen;
    }

    /**
     * Returns the uniformProductNamesAanvraagUrl
     * 
     * @return string $uniformProductNamesAanvraagUrl
     */
    public function getUniformProductNamesAanvraagUrl()
    {
        return $this->uniformProductNamesAanvraagUrl;
    }

    /**
     * Sets the uniformProductNamesAanvraagUrl
     * 
     * @param string $uniformProductNamesAanvraagUrl
     * @return void
     */
    public function setUniformProductNamesAanvraagUrl($uniformProductNamesAanvraagUrl)
    {
        $this->uniformProductNamesAanvraagUrl = $uniformProductNamesAanvraagUrl;
    }

    /**
     * Adds a Uniformeproductnamen
     * 
     * @param \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesUniformeProductnaam
     * @return void
     */
    public function addUniformProductNamesUniformeProductnaam(\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesUniformeProductnaam)
    {
        $this->uniformProductNamesUniformeProductnaam->attach($uniformProductNamesUniformeProductnaam);
    }

    /**
     * Removes a Uniformeproductnamen
     * 
     * @param \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesUniformeProductnaamToRemove The Uniformeproductnamen to be removed
     * @return void
     */
    public function removeUniformProductNamesUniformeProductnaam(\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesUniformeProductnaamToRemove)
    {
        $this->uniformProductNamesUniformeProductnaam->detach($uniformProductNamesUniformeProductnaamToRemove);
    }

    /**
     * Returns the uniformProductNamesUniformeProductnaam
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen> $uniformProductNamesUniformeProductnaam
     */
    public function getUniformProductNamesUniformeProductnaam()
    {
        return $this->uniformProductNamesUniformeProductnaam;
    }

    /**
     * Sets the uniformProductNamesUniformeProductnaam
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen> $uniformProductNamesUniformeProductnaam
     * @return void
     */
    public function setUniformProductNamesUniformeProductnaam(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $uniformProductNamesUniformeProductnaam)
    {
        $this->uniformProductNamesUniformeProductnaam = $uniformProductNamesUniformeProductnaam;
    }

    /**
     * Adds a Uniformeproductnamen
     * 
     * @param \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesGerelateerdProduct
     * @return void
     */
    public function addUniformProductNamesGerelateerdProduct(\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesGerelateerdProduct)
    {
        $this->uniformProductNamesGerelateerdProduct->attach($uniformProductNamesGerelateerdProduct);
    }

    /**
     * Removes a Uniformeproductnamen
     * 
     * @param \Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesGerelateerdProductToRemove The Uniformeproductnamen to be removed
     * @return void
     */
    public function removeUniformProductNamesGerelateerdProduct(\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen $uniformProductNamesGerelateerdProductToRemove)
    {
        $this->uniformProductNamesGerelateerdProduct->detach($uniformProductNamesGerelateerdProductToRemove);
    }

    /**
     * Returns the uniformProductNamesGerelateerdProduct
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen> $uniformProductNamesGerelateerdProduct
     */
    public function getUniformProductNamesGerelateerdProduct()
    {
        return $this->uniformProductNamesGerelateerdProduct;
    }

    /**
     * Sets the uniformProductNamesGerelateerdProduct
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Proudnerds\PnUniformProductNames\Domain\Model\Uniformeproductnamen> $uniformProductNamesGerelateerdProduct
     * @return void
     */
    public function setUniformProductNamesGerelateerdProduct(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $uniformProductNamesGerelateerdProduct)
    {
        $this->uniformProductNamesGerelateerdProduct = $uniformProductNamesGerelateerdProduct;
    }

    /**
     * Returns the UniformProductNamesAbstract
     *
     * @return string
     */
    public function getUniformProductNamesAbstract()
    {
        return $this->uniformProductNamesAbstract;
    }

    /**
     * Sets the UniformProductNamesAbstract
     *
     * @param string $uniformProductNamesAbstract
     * @return void
     */
    public function setUniformProductNamesAbstract($uniformProductNamesAbstract)
    {
        $this->uniformProductNamesAbstract = $uniformProductNamesAbstract;
    }

    /**
     * Returns the UniformProductNamesProductHtml
     *
     * @return string
     */
    public function getUniformProductNamesProductHtml()
    {
        return $this->uniformProductNamesProductHtml;
    }

    /**
     * Sets the UniformProductNamesProductHtml
     *
     * @param string $uniformProductNamesProductHtml
     * @return void
     */
    public function setUniformProductNamesProductHtml($uniformProductNamesProductHtml)
    {
        $this->uniformProductNamesProductHtml = $uniformProductNamesProductHtml;
    }

    /**
     * Returns the UniformProductNamesLanguage
     *
     * @return string
     */
    public function getUniformProductNamesLanguage()
    {
        return $this->uniformProductNamesLanguage;
    }

    /**
     * Sets the UniformProductNamesLanguage
     *
     * @param string $uniformProductNamesLanguage
     * @return void
     */
    public function setUniformProductNamesLanguage($uniformProductNamesLanguage)
    {
        $this->uniformProductNamesLanguage = $uniformProductNamesLanguage;
    }
}
