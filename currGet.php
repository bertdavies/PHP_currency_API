<?php

function currGet($f,$t,$error_hash,$g_codes)
{
//-----------------------------------------------------------------
//--
//--    currGet by Albert Davies    11/2018
//--
//--    1. Tests parameters
//--    2. Calculates new rate
//--    3. Creates both XML and JSON string from Format.xOut
//--    4. Outputs requested method 
//--
//-----------------------------------------------------------------
    //$f - 'from' currency data array (index explained in Format->xOut)
    //$t - 'to' currency data array
    //$a - 'ammount' 

    $format = '';

    if (isset($_GET['format']))
    {
        $format = $_GET['format'];
    }

    
    testParamsGiven($_GET,$error_hash);         //Checks the parameters are set
    testParamsRecognized($_GET,$error_hash);    //Checks parameters are leagle
    testParamsAmGiven($_GET,$error_hash);       //Checks the ammount of params given

    testCurrencyCode($_GET['from'], $g_codes, $error_hash, $format);    //FROM
    testCurrencyCode($_GET['to'], $g_codes, $error_hash, $format);      //TO

    $a = testAmmount($_GET['amnt'],$error_hash,$format);                //Checks the ammount variable for validation
    $frmt = testFormat($format ,$error_hash);                           //Checks the format is leagle

    
    //Calculates the total conversion rate
    $total =(($a/$f[2])*$t[2]);     //[2] is currency rate


    //Format results into XML
    $xml = new Format;
    $xml_return = $xml->xOut($f,$t,$a,$total);
    

    //Convert XML object into JSON
    $json_parse = simplexml_load_string($xml_return);
    $json = json_encode($json_parse); 
    $json_return = json_decode($json,TRUE);
    

        //Logic to output requested encoding
        if ($frmt == 'xml'|| $frmt == NULL)         //REQUEST XML
        {
            header('Content-type: text/xml');
            echo $xml_return;
            $function_return = $xml_return;
        } 
        elseif ($frmt == 'json')    //REQUEST JSON
        {
            header('Content-type: application/json');
            echo json_encode($json_return);
            $function_return = json_encode($json_return);
        }
    return $function_return;    
}


