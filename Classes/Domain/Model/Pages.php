<?php

namespace Proudnerds\PnUniformProductNames\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
class Pages extends AbstractEntity
{
    /**
     * uniformProductNamesAudience
     *
     * @var string
     */
    protected string $uniformProductNamesAudience = '';

    /**
     * uniformProductNamesOnlineAanvragen
     *
     * @var string
     */
    protected string $uniformProductNamesOnlineAanvragen = '';

    /**
     * uniformProductNamesAanvraagUrl
     *
     * @var string
     */
    protected string $uniformProductNamesAanvraagUrl = '';

    /**
     * uniformProductNamesAbstract
     *
     * @var string
     */
    protected string $uniformProductNamesAbstract = '';

    /**
     * uniformProductNamesProductHtml
     *
     * @var string
     */
    protected string $uniformProductNamesProductHtml = '';

    /**
     * uniformProductNamesLanguage
     *
     * @var string
     */
    protected string $uniformProductNamesLanguage = '';

    /**
     * uniformProductNamesUniformeProductnaam
     *
     * @var ObjectStorage<Uniformeproductnamen>
     */
    #[\TYPO3\CMS\Extbase\Attribute\ORM\Lazy()]
    protected ObjectStorage $uniformProductNamesUniformeProductnaam;

    /**
     * uniformProductNamesGerelateerdProduct
     *
     * @var ObjectStorage<Uniformeproductnamen>
     */
    #[\TYPO3\CMS\Extbase\Attribute\ORM\Lazy()]
    protected ObjectStorage $uniformProductNamesGerelateerdProduct;

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
     */
    protected function initStorageObjects(): void
    {
        $this->uniformProductNamesUniformeProductnaam = new ObjectStorage();
        $this->uniformProductNamesGerelateerdProduct = new ObjectStorage();
    }

    /**
     * Returns the uniformProductNamesAudience
     *
     * @return string $uniformProductNamesAudience
     */
    public function getUniformProductNamesAudience(): string
    {
        return $this->uniformProductNamesAudience;
    }

    /**
     * Sets the uniformProductNamesAudience
     *
     * @param string $uniformProductNamesAudience
     */
    public function setUniformProductNamesAudience(string $uniformProductNamesAudience): void
    {
        $this->uniformProductNamesAudience = $uniformProductNamesAudience;
    }

    /**
     * Returns the uniformProductNamesOnlineAanvragen
     *
     * @return string $uniformProductNamesOnlineAanvragen
     */
    public function getUniformProductNamesOnlineAanvragen(): string
    {
        return $this->uniformProductNamesOnlineAanvragen;
    }

    /**
     * Sets the uniformProductNamesOnlineAanvragen
     *
     * @param string $uniformProductNamesOnlineAanvragen
     */
    public function setUniformProductNamesOnlineAanvragen(string $uniformProductNamesOnlineAanvragen): void
    {
        $this->uniformProductNamesOnlineAanvragen = $uniformProductNamesOnlineAanvragen;
    }

    /**
     * Returns the uniformProductNamesAanvraagUrl
     *
     * @return string $uniformProductNamesAanvraagUrl
     */
    public function getUniformProductNamesAanvraagUrl(): string
    {
        return $this->uniformProductNamesAanvraagUrl;
    }

    /**
     * Sets the uniformProductNamesAanvraagUrl
     *
     * @param string $uniformProductNamesAanvraagUrl
     */
    public function setUniformProductNamesAanvraagUrl(string $uniformProductNamesAanvraagUrl): void
    {
        $this->uniformProductNamesAanvraagUrl = $uniformProductNamesAanvraagUrl;
    }

    /**
     * Adds a Uniformeproductnamen
     *
     * @param Uniformeproductnamen $uniformProductNamesUniformeProductnaam
     */
    public function addUniformProductNamesUniformeProductnaam(
        Uniformeproductnamen $uniformProductNamesUniformeProductnaam
    ): void {
        $this->uniformProductNamesUniformeProductnaam->attach($uniformProductNamesUniformeProductnaam);
    }

    /**
     * Removes a Uniformeproductnamen
     *
     * @param Uniformeproductnamen $uniformProductNamesUniformeProductnaamToRemove The Uniformeproductnamen to be removed
     */
    public function removeUniformProductNamesUniformeProductnaam(
        Uniformeproductnamen $uniformProductNamesUniformeProductnaamToRemove
    ): void {
        $this->uniformProductNamesUniformeProductnaam->detach($uniformProductNamesUniformeProductnaamToRemove);
    }

    /**
     * Returns the uniformProductNamesUniformeProductnaam
     *
     * @return ObjectStorage|null $uniformProductNamesUniformeProductnaam
     */
    public function getUniformProductNamesUniformeProductnaam(): ?ObjectStorage
    {
        return $this->uniformProductNamesUniformeProductnaam;
    }

    /**
     * Sets the uniformProductNamesUniformeProductnaam
     *
     * @param ObjectStorage<Uniformeproductnamen> $uniformProductNamesUniformeProductnaam
     */
    public function setUniformProductNamesUniformeProductnaam(ObjectStorage $uniformProductNamesUniformeProductnaam): void
    {
        $this->uniformProductNamesUniformeProductnaam = $uniformProductNamesUniformeProductnaam;
    }

    /**
     * Adds a Uniformeproductnamen
     *
     * @param Uniformeproductnamen $uniformProductNamesGerelateerdProduct
     */
    public function addUniformProductNamesGerelateerdProduct(Uniformeproductnamen $uniformProductNamesGerelateerdProduct): void
    {
        $this->uniformProductNamesGerelateerdProduct->attach($uniformProductNamesGerelateerdProduct);
    }

    /**
     * Removes a Uniformeproductnamen
     *
     * @param Uniformeproductnamen $uniformProductNamesGerelateerdProductToRemove The Uniformeproductnamen to be removed
     */
    public function removeUniformProductNamesGerelateerdProduct(
        Uniformeproductnamen $uniformProductNamesGerelateerdProductToRemove
    ): void {
        $this->uniformProductNamesGerelateerdProduct->detach($uniformProductNamesGerelateerdProductToRemove);
    }

    /**
     * Returns the uniformProductNamesGerelateerdProduct
     *
     * @return ObjectStorage|null $uniformProductNamesGerelateerdProduct
     */
    public function getUniformProductNamesGerelateerdProduct(): ?ObjectStorage
    {
        return $this->uniformProductNamesGerelateerdProduct;
    }

    /**
     * Sets the uniformProductNamesGerelateerdProduct
     *
     * @param ObjectStorage<Uniformeproductnamen> $uniformProductNamesGerelateerdProduct
     */
    public function setUniformProductNamesGerelateerdProduct(ObjectStorage $uniformProductNamesGerelateerdProduct): void
    {
        $this->uniformProductNamesGerelateerdProduct = $uniformProductNamesGerelateerdProduct;
    }

    /**
     * Returns the UniformProductNamesAbstract
     *
     * @return string
     */
    public function getUniformProductNamesAbstract(): string
    {
        return $this->uniformProductNamesAbstract;
    }

    /**
     * Sets the UniformProductNamesAbstract
     *
     * @param string $uniformProductNamesAbstract
     */
    public function setUniformProductNamesAbstract(string $uniformProductNamesAbstract): void
    {
        $this->uniformProductNamesAbstract = $uniformProductNamesAbstract;
    }

    /**
     * Returns the UniformProductNamesProductHtml
     *
     * @return string
     */
    public function getUniformProductNamesProductHtml(): string
    {
        return $this->uniformProductNamesProductHtml;
    }

    /**
     * Sets the UniformProductNamesProductHtml
     *
     * @param string $uniformProductNamesProductHtml
     */
    public function setUniformProductNamesProductHtml(string $uniformProductNamesProductHtml): void
    {
        $this->uniformProductNamesProductHtml = $uniformProductNamesProductHtml;
    }

    /**
     * Returns the UniformProductNamesLanguage
     *
     * @return string
     */
    public function getUniformProductNamesLanguage(): string
    {
        return $this->uniformProductNamesLanguage;
    }

    /**
     * Sets the UniformProductNamesLanguage
     *
     * @param string $uniformProductNamesLanguage
     */
    public function setUniformProductNamesLanguage(string $uniformProductNamesLanguage): void
    {
        $this->uniformProductNamesLanguage = $uniformProductNamesLanguage;
    }
}
