<?php

$filename = $_SERVER['DOCUMENT_ROOT'].'/log2.txt';
$dh = fopen ($filename,'a+');
fwrite($dh, var_export($_POST,true));
fclose($dh);
/*
$data_insert=$_POST;


require_once $_SERVER['DOCUMENT_ROOT'].'/google/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/google/client_secret.json');
$client->setApplicationName("Sheets API Testing");
$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds','https://www.googleapis.com/auth/spreadsheets']);
$fileId = '1TTUeD7QbPOZCERznfnkS1eLni8nuqXVGDdc27bZJdbw';
$tokenArray = $client->fetchAccessTokenWithAssertion();
$accessToken = $tokenArray["access_token"];
$service = new Google_Service_Drive($client);
*/

$data_insert=$_POST;
$data_insert[2]=str_replace("+","",$data_insert[2]);
$data_insert[2]=str_replace("'","",$data_insert[2]);
// Подключаем клиент Google таблиц
require_once __DIR__ . '/vendor/autoload.php';
// Наш ключ доступа к сервисному аккаунту
$googleAccountKeyFilePath = __DIR__ . '/client_secret.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);
$client = new Google_Client();
// Устанавливаем полномочия
$client->useApplicationDefaultCredentials();
// Добавляем область доступа к чтению, редактированию, созданию и удалению таблиц
//$client->addScope('https://www.googleapis.com/auth/spreadsheets');
$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds','https://www.googleapis.com/auth/spreadsheets']);

$service = new Google_Service_Sheets($client);
// ID таблицы

$fileId = '1oOQwAnPCSIGg12-x7yJkGmSBNyUwkjBEYvd1i1Jud4s';
$tokenArray = $client->fetchAccessTokenWithAssertion();
$accessToken = $tokenArray["access_token"];
$service = new Google_Service_Drive($client);




$results = $service->files->get($fileId);
$service = new Google_Service_Sheets($client); 

$result = $service->spreadsheets_values->get($fileId, "Лист1!A:A");
$numRows = $result->getValues() != null ? count($result->getValues()) : 0;
$numRows=$numRows+1;

$EN = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');


$valueRange= new Google_Service_Sheets_ValueRange();
$valueRange->setValues(["values" => $data_insert]); 
$options = ["valueInputOption" => "RAW"];
$result = $service->spreadsheets_values->update($fileId, 'Лист1!A'.$numRows.':'.($EN[count($data_insert)-1]).$numRows.'', $valueRange, $options);

?>