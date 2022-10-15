<?php 

// Отправка смс с кодом клиенту
if(!empty($_POST['cod_sms']) && !empty($_POST['telephone_sms'])){
	
	include 'smsc/smsc_api.php';
	
	
	$cod_sms = $_POST['cod_sms'];
	$telephone_sms = $_POST['telephone_sms'];

	 // Отправка смс с кодом клиенту
	//list($sms_id, $sms_cnt, $cost, $balance) = send_sms($telephone_sms, "Ваш код: " . $cod_sms, 1);
	list($sms_id, $sms_cnt, $cost, $balance) = send_sms($telephone_sms, "Ваш код: " . $cod_sms . "\n Заказ с сайта prosushi.kz", 1);
	
	
	$telephone_sms=str_replace("-","",$telephone_sms);
	$telephone_sms=str_replace(" ","",$telephone_sms);
	$telephone_sms=str_replace("(","",$telephone_sms);
	$telephone_sms=str_replace(")","",$telephone_sms);
	$telephone_sms=trim($telephone_sms);
	
	
	$param=array();
	$param['secret'] = "i9HBDy9kzRYdiQnNdQnzEDhARZKys7eE7R6z95KyHyBT8QtbsHAYaGfRsSaKQedKY88Y4GeA4Ff3hB4D9riaZtSdaSQRZTnGSisGTA7K6bAbErFEFREs9iz949QQT5iAbD7Y34yY6TZz9r3F7tZ6Ef6tfH83BfnDHhkAaGf6r6rnieTfBFa5Q7kZEiN5s3t49Gr9dA5tshHErsKRZNHBGZi97Z4kKidHTtHZSBd9KQE36bESQbeh2rhYa9";
	$param['client_phone']  = urlencode($telephone_sms);
		
	//подготовка запроса				
	foreach ($param as $key => $value) { 
	$data .= "&".$key."=".$value;
	}


	//отправка
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://app.frontpad.ru/api/index.php?get_client");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);

	if ($result){
		$result=json_decode($result,true);
		echo 'У вас '.$result['score'].' бонусов';
	}
	
	$filename = dirname(__FILE__).'/log-post211.txt';
	$dh = fopen ($filename,'a+');
	fwrite($dh, var_export($_POST,true));
	fclose($dh);

	$filename = dirname(__FILE__).'/log-result.txt';
	$dh = fopen ($filename,'a+');
	fwrite($dh, var_export($result,true));
	fclose($dh);
	
	

}
?>