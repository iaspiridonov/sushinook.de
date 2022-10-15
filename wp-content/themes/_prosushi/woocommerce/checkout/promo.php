<?php
if ($_POST['certificate']){
	$certificate=$_POST['certificate'];

	$param=array();
	$param['secret'] = "i9HBDy9kzRYdiQnNdQnzEDhARZKys7eE7R6z95KyHyBT8QtbsHAYaGfRsSaKQedKY88Y4GeA4Ff3hB4D9riaZtSdaSQRZTnGSisGTA7K6bAbErFEFREs9iz949QQT5iAbD7Y34yY6TZz9r3F7tZ6Ef6tfH83BfnDHhkAaGf6r6rnieTfBFa5Q7kZEiN5s3t49Gr9dA5tshHErsKRZNHBGZi97Z4kKidHTtHZSBd9KQE36bESQbeh2rhYa9";
	$param['certificate']  = urlencode($certificate);
		
	//подготовка запроса				
	foreach ($param as $key => $value) { 
	$data .= "&".$key."=".$value;
	}


	//отправка
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?get_certificate");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);


	$result=json_decode($result,true);
	
	
	
	if ($result['result']=="success"){
		if ($result['sale']){
			$mess="Скидка на заказ ".$result['sale'].'%';
		} else if ($result['name']){
			$mess="Подарок к заказу: ".$result['name'].'';
		} else if ($result['amount']){
			$mess="Сертификат на сумму ".$result['amount'].' KZT';
		}
	} else {
		$mess="Ошибка. Сертификат не найден или уже был использован.";		
	}
		
		echo $mess;
	
	
}

/*

(
    [result] => success
    [sale] => 50
)

Array
(
    [result] => success
    [product_id] => 
    [name] => 7Up 0,5л.
    [price] => 0
)

Array
(
    [result] => success
    [amount] => 3000
)


*/
?>