<?php


$data_insert=$_POST;

/*
$data_insert=$_POST;
$data_insert=array(
  0 => 73435,
  1 => 'еуыеее',
  2 => '+79012345685',
  3 => '[:ru]Пик[:kz]Сет 1[:] x 1шт.;',
  4 => '3690',
  5 => 'cod',
  6 => 'free_shipping:11',
  7 => 'фывфыв',
  8 => '1',
  9 => '3311',
  10 => ' ',
  11 => ' ',
  12 => 'фыыфвфывфывыфвыфв',
  13 => '13:20:30',
  14 => 'https://prosushi.kz/checkout/',
  15 => ' ',
  16 => ' ',
  17 => ' ',
  18 => ' ',
  19 => ' ',
);*/

require_once $_SERVER['DOCUMENT_ROOT'].'/google/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/google/client_secret.json');
$client->setApplicationName("Sheets API Testing");
$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds','https://www.googleapis.com/auth/spreadsheets']);
$fileId = '187bRcQ6S8pIKXKnyUC_-Z7JiNty6JYUE9S3yAX2joT8';
$tokenArray = $client->fetchAccessTokenWithAssertion();
$accessToken = $tokenArray["access_token"];
$service = new Google_Service_Drive($client);
$results = $service->files->get($fileId);
$service = new Google_Service_Sheets($client); 

$result = $service->spreadsheets_values->get($fileId, "Лист1!A:A");
$numRows = $result->getValues() != null ? count($result->getValues()) : 0;
$numRows=$numRows+1;

$EN = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

//$data_insert=array("test","test2","","test3");

$valueRange= new Google_Service_Sheets_ValueRange();
$valueRange->setValues(["values" => $data_insert]); 
$options = ["valueInputOption" => "RAW"];
$result = $service->spreadsheets_values->update($fileId, 'Лист1!A'.$numRows.':'.($EN[count($data_insert)-1]).$numRows.'', $valueRange, $options);

//print_r($result);


$filename = dirname(__FILE__).'/log-result111.txt';
$dh = fopen ($filename,'a+');
fwrite($dh, var_export($result,true));
fclose($dh);


?>