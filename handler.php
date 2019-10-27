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


?>