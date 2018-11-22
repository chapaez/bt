<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Bot\Models;

class rndCommand extends UserCommand
{
    protected $name = 'rnd';                      // Your command's name
    protected $description = 'get random phrase'; // Your command description
    protected $usage = '/rnd';                    // Usage of your command
    protected $version = '0.1.0';                  // Version of your command

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        $word = new Models\Word();
        $randomWord = $word->getRandom()['data'];
        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $randomWord['en'].' translates to '.$randomWord['ru'], // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
}