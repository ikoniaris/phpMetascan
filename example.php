<?php
require_once(__DIR__ . '/phpMetascanAPI.class.php');

$api_key    = '42c00f42f044947a5870dacbe02e6539';

$file       = __DIR__.'/test_file.txt';
$data_id    = '548f59618bd543e89d8d71ed5fb1f745';
$hash       = '098F6BCD4621D373CADE4E832627B4F6';

$phpMetascan = new phpMetascanAPI($api_key);

print_r($phpMetascan->fileUpload($file));
print_r($phpMetascan->retrieveReport($data_id));
print_r($phpMetascan->hashLookup($hash));

?>