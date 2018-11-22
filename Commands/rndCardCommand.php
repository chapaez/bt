<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\InlineKeyboardMarkup;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Request;
use Bot\Models;
use Longman\TelegramBot\TelegramLog;

class rndCardCommand extends UserCommand
{
    protected $name = 'rndCard';                // Your command's name
    protected $description = 'get random card'; // Your command description
    protected $usage = '/rndCard';              // Usage of your command
    protected $version = '0.1.0';               // Version of your command

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        $word = new Models\Word();
        $randomWord = $word->getRandom();

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'show', 'callback_data' => 'rnd '.$randomWord['id']],
                    ['text' => 'next', 'callback_data' => 'next']
                ]
            ]
        ];
        $encodedKeyboard = \json_encode($keyboard);

        try {
            TelegramLog::initDebugLog($_SERVER['DOCUMENT_ROOT'] . '/../logs/bot.debug.log');
        } catch (TelegramLogException $e) {

        }
        /*try {
            $inline_keyboard = [
                new InlineKeyboardButton(['text' => 'inline', 'switch_inline_query' => 'true']),
                new InlineKeyboardButton(['text' => 'callback', 'callback_data' => 'identifier']),
                new InlineKeyboardButton(['text' => 'open url', 'url' => 'https://github.com/akalongman/php-telegram-bot']),
            ];
        } catch (TelegramException $e) {
            TelegramLog::debug($e->getMessage());
        }*/
        try {
            $data = [                                  // Set up the new message data
                'chat_id' => $chat_id,                 // Set Chat ID to send the message to
                'text' => $randomWord['data']['en'] . ' translates as...', // Set message to send
                'reply_markup' => $encodedKeyboard
                //new InlineKeyboardMarkup(['inline_keyboard' => [$inline_keyboard]])
            ];


            return Request::sendMessage($data);        // Send message!
        } catch (TelegramException $e) {
            TelegramLog::debug($e->getMessage());
        }
    }
}