<?php
error_reporting(0);
include 'rb-sqlite.php';
R::setup( 'sqlite:stickers.sqlite');
if ( !R::testConnection()) {
	exit();
}
define('TOKEN', 'YOU BOT TOKEN');
define('API', 'https://api.telegram.org/bot'.TOKEN.'/');

$result = json_decode(file_get_contents('php://input'));

$ids = R::getCol('select id from list');
$id = mt_rand(0, count($ids)-1);
$list = R::load( 'list' , $ids[$id] );

$emoji_list = ['😀','😁','😂','🤣','😃','😄','😅','😆','😉','😊','😋','😎','😍','😘','🥰','😗','😙','😚','🤗','🤩','😏','😴','😝','🤑','🤯'];
$emoji = array_rand($emoji_list);
$emoji = $emoji_list[$emoji];

$btn = [
	'keyboard' => [
		[$emoji.' Хочу еще стикер '.$emoji]
	],
	'resize_keyboard' => true
];

$data = [
    'chat_id' => $result->message->chat->id, 
    'reply_markup' => json_encode($btn),
    'sticker' => $list->sticker
];

file_get_contents(API.'sendSticker?'.http_build_query($data));

// Save Sticker ID to sqlite database
if (isset($result->message->sticker->file_id)){
	R::exec('INSERT OR IGNORE INTO list VALUES (null,"'.$result->message->sticker->file_id.'")');
}
