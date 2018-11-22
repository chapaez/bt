<?php
// Load composer
/*require __DIR__ . '/../vendor/autoload.php';

$bot_api_key  = '';
$bot_username = '';
$hook_url     = '';
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
    //var_dump($telegram);
   // die('d');

    // Set webhook
    $result = $telegram->unsetWebhook();
    $result = $telegram->setWebhook($hook_url);

    if ( $result->isOk() ) {
        echo $result->getDescription();
    } else {
        echo 'er';
    }
} catch ( Longman\TelegramBot\Exception\TelegramException $e ) {
    // log telegram errors
     echo $e->getMessage();
}*/