<?php
$private_key = 'E7UrscnO9nX3zJC8HWpDxFws7byK4NGXDuYf0jD4';
require __DIR__ . '/vendor/autoload.php';
// слушатель статуса
$sign = base64_encode( sha1(
    $private_key .
    $_POST['data'] .
    $private_key
    , 1 ));

$payment_data = 'Статус платежа по счет-фактуре №';
if(isset($sign) && $sign == $_POST['signature'])
{
    $status = json_decode(base64_decode($_POST['data']), true);
    $payment_data .= $status['order_id'].': '.$status['status'].'/n Номер карты: '.$status['sender_card_mask2'].'/n Сумма:'.$status['amount'].' UAH';
}

echo $payment_data;

$bot_username = "proflist_bot";
$bot_api_key = '632953198:AAEP2-FffWD3CGeF6-fqW_m2UZMstRUvzis';

// trying to create Bot Instance
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Handle telegram webhook request
    //$telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    echo $e->getMessage();
}
// https://api.telegram.org/bot414031990:AAHf7RyeT63jIXuJ9BlWxTL23yifij86fK0/getUpdates
$array = [];
$client = new GuzzleHttp\Client();

$response = $client->get('https://api.telegram.org/bot'.$bot_api_key.'/getUpdates')->getBody();

$data = json_decode($response);

foreach($data->result as $item){
    $array[] = $item->message->chat->id;
}
array_unique($array);

$result = \Longman\TelegramBot\Request::sendMessage(['chat_id' => "-241903841", 'text' => $payment_data]);

echo $result;

?>


