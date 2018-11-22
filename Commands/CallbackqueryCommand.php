<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Bot\Models;
use Longman\TelegramBot\TelegramLog;


/**
 * callback rnd command
 */
class CallbackqueryCommand extends SystemCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'callbackquery';
    protected $description = 'Reply to callback query';
    protected $version = '1.0.0';
    /**#@-*/

    private function sendNewWord() {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID
        $word = new Models\Word();
        $randomWord = $word->getRandom();

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'show', 'callback_data' => 'callbackrnd '.$randomWord['id']],
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
                'text' => $randomWord['data']['en'] . ' translates to ' . $randomWord['data']['ru'], // Set message to send
                'reply_markup' => $encodedKeyboard
                //new InlineKeyboardMarkup(['inline_keyboard' => [$inline_keyboard]])
            ];


            return Request::sendMessage($data);        // Send message!
        } catch (TelegramException $e) {
            TelegramLog::debug($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            TelegramLog::initDebugLog($_SERVER['DOCUMENT_ROOT'] . '/../logs/bot.debug2.log');
        } catch (TelegramLogException $e) {
        }
        $update = $this->getUpdate();
        TelegramLog::debug('fst');
        TelegramLog::debug($update);
        TelegramLog::debug($update->getCallbackQuery()->getMessage());
        TelegramLog::debug($update->getUpdateId());
        TelegramLog::debug('2nd');
        $callback_query = $update->getCallbackQuery();
        $callback_query_id = $callback_query->getId();
        $callback_data = $callback_query->getData();


        TelegramLog::debug($update);
        TelegramLog::debug('3rd');

        $message = $callback_query->getMessage();
        $chat_id = $message->getChat()->getId();

        $data['callback_query_id'] = $callback_query_id;

        if (substr($callback_data,0, 3 ) == 'rnd') {
            $id = intval( substr( $callback_data, 4 ) );
            $word = new Models\Word();
            $translation = $word->getOne($id)['ru'];
            $data['text'] = $translation;
            $data['show_alert'] = true;
        } elseif ( $callback_data == 'next' ) {
            /*$this->sendNewWord();

            $data['text'] = 'next one!';
            $data['show_alert'] = false;*/
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
            $data = [                                  // Set up the new message data
                'chat_id' => $chat_id,                 // Set Chat ID to send the message to
                'text' => $randomWord['data']['en'] . ' translates as...', // Set message to send
                'reply_markup' => $encodedKeyboard
            ];
            //Request::editMessageText($data);
            Request::sendMessage($data);
            $data['text'] = 'next one!';
            $data['show_alert'] = false;
        } else {
            $data['text'] = 'Hello lol';
            $data['show_alert'] = false;
        }

        return Request::answerCallbackQuery($data);
    }
}
