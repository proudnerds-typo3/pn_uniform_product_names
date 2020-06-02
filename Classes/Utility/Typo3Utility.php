<?php

namespace  Proudnerds\PnUniformProductNames\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Messaging\FlashMessage;

/**
 * Class: Typo3Utility
 * Description: general utilities
 *
 * 2020 Jacco van der Post <jacco.vanderpost@proudnerds.com>, Proud Nerds
 */
class Typo3Utility
{
    /**
     * Get typoscript settings for tx_pnuniformproductnames
     *
     * @return mixed
     */
    public static function getSettings()
    {
        $configurationManager = GeneralUtility::makeInstance(BackendConfigurationManager::class);
        $typoScriptSettings = $configurationManager->getTypoScriptSetup();

        $typoScriptService = GeneralUtility::makeInstance(\TYPO3\CMS\Core\TypoScript\TypoScriptService::class);
        $typoScriptSettingsWithoutDots = $typoScriptService->convertTypoScriptArrayToPlainArray($typoScriptSettings);

        $settings = $typoScriptSettingsWithoutDots['plugin']['tx_pnuniformproductnames']['settings'];

        return $settings;
    }

    /**
     * Check if an object is empty
     *
     * @param $obj
     *
     * @return bool
     */
    public static function emptyObj($obj)
    {
        foreach ($obj AS $prop) {
            return false;
        }

        return true;
    }

    /**
     * Show a flash message
     *
     * @param string $message The message.
     * @param string $title Optional message title.
     * @param int $severity Optional severity, must be either of one of \TYPO3\CMS\Core\Messaging\FlashMessage constants
     * @param bool $storeInSession Optional, defines whether the message should be stored in the session or only for one request (default)
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public static function flashmessage($message = '', $title = '', $severity = FlashMessage::INFO, $storeInSession = false)
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $flashMessageService = $objectManager->get(flashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $addMessage = GeneralUtility::makeInstance(FlashMessage::class,
            $message,
            $title,
            $severity,
            $storeInSession
        );

        $messageQueue->addMessage($addMessage);
    }
}