<?php
define('TOKEN', 'YOU BOT TOKEN');
define('API', 'https://api.telegram.org/bot'.TOKEN.'/');

$result = json_decode(file_get_contents('php://input'));

$txt = file('stickers.txt'); 
$sticker =  $txt[rand(0,(count($txt)-1))];
unset($txt); 
$sticker = mb_substr($sticker, 0,-1);

$emoji_list = array('😀','😁','😂','🤣','😃','😄','😅','😆','😉','😊','😋','😎','😍','😘','🥰','😗','😙','😚','🤗','🤩','😏','😴','😝','🤑','🤯');
$emoji = array_rand($emoji_list);
$emoji = $emoji_list[$emoji];

$btn = array(
	'keyboard' => array(
		array($emoji.' Хочу еще стикер '.$emoji)
	),
	'resize_keyboard' => true
);

$data = array(
    'chat_id' => $result->message->chat->id, 
    'reply_markup' => json_encode($btn),
    'sticker' => $sticker
);

file_get_contents(API.'sendSticker?' . http_build_query($data));

// Save Sticker ID to txt database
if (isset($result->message->sticker->file_id)){
	//file_put_contents('stickers.txt', PHP_EOL .$result->message->sticker->file_id, FILE_APPEND | LOCK_EX);
}

// Write log file
//file_put_contents('log.txt',$str.PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
