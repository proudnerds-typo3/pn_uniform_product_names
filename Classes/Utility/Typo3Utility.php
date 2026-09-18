<?php

namespace Proudnerds\PnUniformProductNames\Utility;

use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
     * @return array
     */
    public static function getSettings(string $pluginSignature = 'pnuniformproductnames', int $pageId = 0): array
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);

        $request = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE)
            ->withQueryParams(['id' => $pageId]);
        $configurationManager->setRequest($request);

        $fullTypoScript = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );

        $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
        $plainTypoScript = $typoScriptService->convertTypoScriptArrayToPlainArray($fullTypoScript);

        return $plainTypoScript['plugin']['tx_' . strtolower($pluginSignature)]['settings'] ?? [];
    }

    /**
     * Show a flash message
     *
     * @param string $message The message.
     * @param string $title Optional message title.
     * @param int|ContextualFeedbackSeverity $severity Optional severity, must be either of one of \TYPO3\CMS\Core\Messaging\FlashMessage constants
     * @param bool $storeInSession Optional, defines whether the message should be stored in the session or only for one request (default)
     * @throws Exception
     */
    public static function flashmessage(string $message = '', string $title = '', ContextualFeedbackSeverity|int $severity = ContextualFeedbackSeverity::INFO, $storeInSession = false): void
    {
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            $message,
            $title,
            $severity,
            $storeInSession
        );

        $messageQueue->enqueue($message);
    }
}
