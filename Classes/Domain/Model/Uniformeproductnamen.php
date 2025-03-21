<?php

namespace Proudnerds\PnUniformProductNames\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * Uniformeproductnamen
 */
class Uniformeproductnamen extends AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    #[Validate([
        'validator' => 'NotEmpty',
    ])]
    protected string $title = '';

    /**
     * uri
     *
     * @var string
     */
    #[Validate([
        'validator' => 'NotEmpty',
    ])]
    protected string $uri = '';

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the Uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Sets the Uri
     *
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }
}
