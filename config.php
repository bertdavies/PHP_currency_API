<?php
//Sets time zone
date_default_timezone_set('GMT');



//Includes
require_once('functions.php');
require_once('errorHandle.php');
require_once('currGet.php');
require_once('currPost.php');
require_once('currDel.php');
require_once('currPut.php');
require_once('create_rates_file.php');


//Error Codes
$error_hash = array(
    1000 => 'Required parameter is missing',
    1100 => 'Parameter not recognized',
    1200 => 'Currency type not recognized',
    1300 => 'Currency amount must be a decimal number',
    1400 => 'Format must be xml or json',
    1500 => 'Error in service',
    2000 => 'Method not recognized or is missing',
    2100 => 'Rate in wrong format or is missing',           
    2200 => 'Currency code in wrong format or is missing',  
    2300 => 'Country name in wrong format or is missing',   
    2400 => 'Currency code not found for update',            
    2500 => 'Error in service'                              
);


//Global Country Codes Array
$g_codes = array(
    'AUD','BRL','CAD','CHF',
    'CNY','DKK','EUR','GBP',
    'HKD','HUF','INR','JPY',
    'MXN','MYR','NOK','NZD',
    'PHP','RUB','SEK','SGD',
    'THB','TRY','USD','ZAR'
);


//Update rates.xml
if (time()-filemtime('rates.xml') > 12 * 3600) {
    // file older than 12 hours
    $serializedData = serialize($g_codes);
    file_put_contents('new_rates_array.txt', $serializedData);    
    createRates($g_codes);
}


//Adds any currency codes from previous PUT requests to g_codes[]
$recoveredData = file_get_contents('new_rates_array.txt');
$g_codes = unserialize($recoveredData);


//Initialize
$just_put = FALSE;//stops currPut to echo XML
$just_del = FALSE;//stops currDel to echo XML

$from = '';
$to = '';

if (isset($_GET['from']))
{
    $from = $_GET['from'];
}
if (isset($_GET['to']))
{
    $to = $_GET['to'];
}


//echo "config complete...."

