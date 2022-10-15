<?php 

// Отправка смс с кодом клиенту
if(!empty($_POST['cod_sms']) && !empty($_POST['telephone_sms'])){
	
	include 'smsc/smsc_api.php';
	
	$whatsAppMessageWasSent = false;
	// Отправка кода в WhatsApp
	try {
		$cod_sms = $_POST['cod_sms'];
		$telephone_sms = $_POST['telephone_sms'];
		
		$phoneForWhatsApp = str_replace("+", "", $telephone_sms);
		$phoneForWhatsApp = str_replace(" ", "", $phoneForWhatsApp);
		
		$dataWhatsApp = [
			"phone" => $phoneForWhatsApp, 
			"body"  => $cod_sms
		];
		$data_string = json_encode($dataWhatsApp, JSON_UNESCAPED_UNICODE);
		$curl = curl_init('https://api.chat-api.com/instance449094/sendMessage?token=cpg2g9sd2526wa81');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		// Принимаем в виде массива. (false - в виде объекта)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		$resultWhatsApp = curl_exec($curl);
		
		$whatsAppMessageWasSent = json_decode($resultWhatsApp)->sent;
		
		curl_close($curl);
	} catch(Exception $e) {
		$whatsAppMessageWasSent = false;
	}
	
	if (!$whatsAppMessageWasSent) {
		// Отправка смс с кодом клиенту
		list($sms_id, $sms_cnt, $cost, $balance) = send_sms($telephone_sms, "Ваш код: " . $cod_sms . "\n Заказ с сайта sushinook.de", 1);
	}
	
	$cod_sms = $_POST['cod_sms'];
	$telephone_sms = $_POST['telephone_sms'];
	
	
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
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.prosushi.kz/api/v1/integration/site/clients/client?phone='.$telephone_sms,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Accept: application/json',
		'Content-Type: application/json',
		'x-token: dEJvonIEGDx82AWvfYAN3G97qbND0Fj8Cuz6xGvQ',
	  ),
	));
	$result = json_decode(curl_exec($curl));
	curl_close($curl);

	if ($result){
		file_put_contents(__DIR__.'/A_result.txt', print_r($result, true));
		echo 'У вас '.($result->data->data->bonuses / 100).' бонусов';

	}
	

}
?>