<?php
namespace Longman\TelegramBot;

class TelegramEBC extends Telegram {
    protected $version = '0.35.2';

    public function addCommandsPath($path, $before = true)
    {
        if( $path == BASE_COMMANDS_PATH . '/UserCommands' ) {
            return $this;
        }

        return parent::addCommandsPath($path, $before = true);
    }

}