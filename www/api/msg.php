<?php
// Load composer
require $_SERVER['DOCUMENT_ROOT'].'/../prolog.php';
use Bot\Models;
use Longman\TelegramBot\TelegramLog;

$word = new Models\Word();
/*Helpers::dmp($word->getAll());
Helpers::dmp($word->getOne(1));
Helpers::dmp($word->getRandom());*/
try {
    TelegramLog::initDebugLog($_SERVER['DOCUMENT_ROOT'] . '/../logs/bot.debug.log');
} catch (\Longman\TelegramBot\Exception\TelegramLogException $e) {
    echo($e->getMessage());
}
TelegramLog::debug('sts');

