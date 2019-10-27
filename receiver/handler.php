<?php

    include 'LiqPay.php';
    header("HTTP/1.0 200 ok");
    
    $private_key = 'E7UrscnO9nX3zJC8HWpDxFws7byK4NGXDuYf0jD4';
    $public_key = 'i15757690222';


    $lq_pay = new LiqPay($public_key, $private_key);
    $order_id = time() + random_int(10,99);
    $description = 'Оплата согласно счета №'.$order_id.' от '.date("d.m.y");

    $data_ret = $lq_pay -> cnb_form([
        'action' => 'pay',
        'version' => '3',
        'amount' => $_POST['amount'],
        'currency' => 'UAH',
        'description' => $description,
        'order_id' => $order_id,
        'sandbox' => '1',
        'server_url' => 'http://proflist.com.ua/receiver/index.php'
    ]);

    echo $data_ret;


$bot_username = "proflist_bot";
$bot_api_key = '632953198:AAEP2-FffWD3CGeF6-fqW_m2UZMstRUvzis';

$cart = $_POST['cart'].' '.$_POST['delivery'].' '.$_POST['deliveryPrice'];
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

$result = \Longman\TelegramBot\Request::sendMessage(['chat_id' => "-241903841", 'text' => $cart]);

echo $result;

?>


