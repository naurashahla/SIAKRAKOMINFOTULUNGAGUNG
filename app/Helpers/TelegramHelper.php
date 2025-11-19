<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class TelegramHelper
{
    /**
     * Base URL for Telegram Bot API
     */
    private const BASE_URL = 'https://api.telegram.org/bot';

    /**
     * Send a simple text message to Telegram
     *
     * @param string $message The message to send
     * @param string|null $chatId Override default chat ID
     * @param string $parseMode Parse mode (HTML, Markdown, MarkdownV2)
     * @return bool|array Returns true on success, false on failure, or response array if $returnResponse is true
     */
    public static function sendMessage(string $message, ?string $chatId = null, string $parseMode = 'HTML')
    {
        Log::warning('[Telegram] sendMessage called but Telegram support has been removed.');
        return false;
    }

    /**
     * Send a message with custom keyboard
     *
     * @param string $message
     * @param array $keyboard
     * @param string|null $chatId
     * @param string $parseMode
     * @return bool|array
     */
    public static function sendMessageWithKeyboard(string $message, array $keyboard, ?string $chatId = null, string $parseMode = 'HTML')
    {
        Log::warning('[Telegram] sendMessageWithKeyboard called but Telegram support has been removed.');
        return false;
    }

    /**
     * Send a formatted notification for events
     *
     * @param string $eventTitle
     * @param string $eventDate
     * @param string $eventTime
     * @param string $location
     * @param string $type (created, updated, reminder)
     * @return bool
     */
    public static function sendEventNotification(string $eventTitle, string $eventDate, string $eventTime, string $location, string $type = 'created')
    {
        Log::warning('[Telegram] sendEventNotification called but Telegram support has been removed.');
        return false;
    }

    /**
     * Get bot information
     *
     * @return array|bool
     */
    public static function getBotInfo()
    {
        Log::warning('[Telegram] getBotInfo called but Telegram support has been removed.');
        return false;
    }

    /**
     * Test telegram connection
     *
     * @return bool
     */
    public static function testConnection(): bool
    {
        Log::warning('[Telegram] testConnection called but Telegram support has been removed.');
        return false;
    }

    /**
     * Check if Telegram is properly configured
     *
     * @return bool
     */
    public static function isConfigured(): bool
    {
        return false;
    }

    /**
     * Get bot token from config
     *
     * @return string|null
     */
    private static function getToken(): ?string
    {
        return null;
    }

    /**
     * Get chat ID from config
     *
     * @return string|null
     */
    private static function getChatId(): ?string
    {
        return null;
    }

    /**
     * Send request to Telegram Bot API
     *
     * @param string $method
     * @param array $data
     * @param bool $returnResponse
     * @return bool|array
     */
    private static function sendTelegramRequest(string $method, array $data = [], bool $returnResponse = false)
    {
        Log::warning('[Telegram] sendTelegramRequest called but Telegram support has been removed.');
        return false;
    }
}
