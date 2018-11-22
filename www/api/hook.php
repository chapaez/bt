<?php
// Load composer
require $_SERVER['DOCUMENT_ROOT'].'/../prolog.php';

use Bot\Config;
use Longman\TelegramBot\TelegramEBC;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;



$log = new Logger('name');

try {
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/t.log', Logger::NOTICE));
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $log->warning('Foo');
    $log->notice('post',$_POST);

    $commands_paths = [
        dirname(dirname( dirname(__FILE__ ) ) ) . '/Commands/'
    ];
    // Create Telegram API object
    $telegram = new TelegramEBC(Config::BOT_KEY, Config::BOT_NAME);
    $telegram->addCommandsPaths($commands_paths);
    ?><pre><?php /*var_dump*/($telegram->getCommandsList());?></pre><?php
    // Handle telegram webhook request
    $telegram->handle();


} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors

     echo $e->getMessage();
}