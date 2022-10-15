<?php
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