<?php

define('TOKEN', 'ABC123');

define('API', 'https://api.telegram.org/bot'.TOKEN.'/');

$result = json_decode(file_get_contents('php://input'));

$txt = file('stickers.txt'); 

$sticker =  $txt[rand(0,(count($txt)-1))];

$sticker = mb_substr($sticker, 0,-1) ;

unset($txt); 

$data = [

    'chat_id' => $result->message->chat->id, 

    'sticker' => $sticker

] ;

file_get_contents(API.'sendSticker?' . http_build_query($data));

// Save sticker ID to stickers.txt

// file_put_contents('stickers.txt', PHP_EOL .$result->message->sticker->file_id, FILE_APPEND);
