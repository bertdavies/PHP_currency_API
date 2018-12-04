<?php
//----------------------------------------------------
//--
//--    Tests for errors by Albert Davies 11/2018
//--    used for getCurr
//--
//----------------------------------------------------






//-----------------------------------------------------------
//--
//--    testCurrCode 
//--
//--    Tests if currency exists in $g_codes (currency arry)
//--
//-----------------------------------------------------------

function testCurrencyCode($verb_value, $g_codes, $error_hash, $frmt)
{

//Create and set Error msg object...
$xml = new Error;
$xml_return = $xml->errorX("1200", $error_hash[1200]);

    if (in_array($verb_value, $g_codes)) 
    {
    return $verb_value;
    }
    else
    {
        if ($frmt == "json")
            {
            //Convert to JSON
            $json_parse = simplexml_load_string($xml_return);
            $json = json_encode($json_parse); 
            $json_return = json_decode($json,TRUE);
            //Output msg
            header('Content-type: application/json');
            echo json_encode($json_return);
            $function_return = json_encode($json_return);
            exit();
            }
        else
            {
            //Format error results into XML
            header('Content-type: text/xml');
            echo $xml_return;
            exit();
            }
    exit();
    }
}

//-----------------------------------------------------------
//--
//--    testAmmount 
//--
//--    Uses regex to test if ammount is a float at 2dp xx.xx
//--
//-----------------------------------------------------------


function testAmmount($verb_value,$error_hash,$frmt)
{
    $xml = new Error;
    $xml_return = $xml->errorX("1300", $error_hash[1300]);


    
    if (!preg_match('/([0-9]{1,})\.([0-9]{2,2})/', $verb_value) == 0) {
        return $verb_value;
    } 
    else 
    {
        if ($frmt == "json")
            {
            //Convert to JSON
            $json_parse = simplexml_load_string($xml_return);
            $json = json_encode($json_parse); 
            $json_return = json_decode($json,TRUE);
            //Output msg
            header('Content-type: application/json');
            echo json_encode($json_return);
            $function_return = json_encode($json_return);
            exit();
            }
        else
            {
            //Format error results into XML
            header('Content-type: text/xml');
            echo $xml_return;
            exit();
            }
    exit();
    }
}



//-----------------------------------------------------------
//--
//--    testFormat 
//--
//--    Tests if format is eith XML, JSON or NULL
//--
//-----------------------------------------------------------

function testFormat($frmt,$error_hash)
{

    if ($frmt =='json' || $frmt =='xml' || $frmt == NULL)
        {
        return $frmt;
        }
    else
        {
        //Format error results into XML -> Incorrect format type..
        $xml = new Error;
        $xml_return = $xml->errorX("1400", $error_hash[1400]);
        header('Content-type: text/xml');
        echo $xml_return;
        exit();
        }
}



//-----------------------------------------------------------
//--
//--    testParamsGiven
//--
//--    Checks that the HTTP verbs exist/are set
//--
//-----------------------------------------------------------

function testParamsGiven($verb,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorX("1000", $error_hash[1000]);

    $format = '';
    if (isset($_GET['format']))
    {
        $format = $_GET['format'];
    }

    //Parameters are set
    if(isset($verb['from']) && isset($verb['to']) && isset($verb['amnt'])) 
    {
        return TRUE;
    }
    else
    {
        if ($format == 'json')
        {
        $json_parse = simplexml_load_string($xml_return);
        $json = json_encode($json_parse); 
        $json_return = json_decode($json,TRUE);
        //Output msg
        header('Content-type: application/json');
        echo json_encode($json_return);
        $function_return = json_encode($json_return);
        exit();
        }
        else
        {
        header('Content-type: text/xml'); 
        echo $xml_return;
        exit();
        }
    }
}


//-----------------------------------------------------------
//--
//--    testParamsRecognized
//--
//--    Checks in the server request array that the parameters
//--    are allowed (from, to, ammount)
//--
//-----------------------------------------------------------

function testParamsRecognized($verb,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorX("1100", $error_hash[1100]);
 

    //Parameters are set
    if (array_key_exists('from', $verb) && array_key_exists('to', $verb) && array_key_exists('amnt', $verb))
        {
            return TRUE;
        }
    else
    {
        if ($verb['format'] == 'json')
        {
        $json_parse = simplexml_load_string($xml_return);
        $json = json_encode($json_parse); 
        $json_return = json_decode($json,TRUE);
        //Output msg
        header('Content-type: application/json');
        echo json_encode($json_return);
        $function_return = json_encode($json_return);
        exit();
        }
        else
        {
        header('Content-type: text/xml'); 
        echo $xml_return;
        exit();
        }
    }  
}


//-----------------------------------------------------------
//--
//--    testParamsAmGive
//--
//--    Tests that the required ammount of params are 
//--    supplied (4)
//--
//-----------------------------------------------------------



function testParamsAmGiven($verb,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorX("1100", $error_hash[1100]);
 
    $counted_array = count($verb);
    //Parameters are set
    if ($counted_array < 5)
        {
            return TRUE;
        }
    else
    {
        if ($verb['format'] == 'json')
        {
        $json_parse = simplexml_load_string($xml_return);
        $json = json_encode($json_parse); 
        $json_return = json_decode($json,TRUE);
        //Output msg
        header('Content-type: application/json');
        echo json_encode($json_return);
        $function_return = json_encode($json_return);
        exit();
        }
        else
        {
        header('Content-type: text/xml'); 
        echo $xml_return;
        exit();
        }
    }    
}





//----------------------------------------------------
//--
//--    Tests for errors by Albert Davies 11/2018
//--    used for POST, PUT and DELETE
//--
//----------------------------------------------------




//-----------------------------------------------------------
//--
//--    testRate
//--
//--    Uses regex to check 2dp float value
//--    Returns formated xml with error if fails
//--
//-----------------------------------------------------------


function testRate($verb_value,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorType("2100", $error_hash[2100]);
    
    if (!preg_match('/([0-9]{1,})\.([0-9]{2,2})/', $verb_value) == 0  && $verb_value != NULL) 
        {
            return $verb_value;
        } 
    else 
        {   
        //Format error results into XML
        header('Content-type: text/xml');
        echo $xml_return;
        exit();
        }
}


//-----------------------------------------------------------
//--
//--    testCode
//--
//--    When currency code is added, checks it is 3xletters
//--    and non numeric
//--
//-----------------------------------------------------------


function testCode($verb_value,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorType("2200", $error_hash[2200]);


    $lengh = strlen($verb_value); 
    
    if ($lengh == 3 && $verb_value != NULL && !is_numeric($verb_value)) 
        {
            return $verb_value;
        } 
    else 
        {   
        //Format error results into XML
        header('Content-type: text/xml');
        echo $xml_return;
        exit();
        }
 }



//-----------------------------------------------------------
//--
//--    testCountry
//--
//--    Checks country added is not null and is non numeric
//--
//-----------------------------------------------------------



function testCountry($verb_value,$error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorType("2300", $error_hash[2300]);

    
    if ($verb_value != NULL && !is_numeric($verb_value)) 
    {
        return $verb_value;
    } 
    else 
    {   
    //Format error results into XML
    header('Content-type: text/xml');
    echo $xml_return;
    exit();
    }
}

//-----------------------------------------------------------
//--
//--    testUpdateArray
//--
//--    Checks code exists in currency code array
//--
//-----------------------------------------------------------


function testUpdateArray($verb_value,$g_codes, $error_hash)
{
    $xml = new Error;
    $xml_return = $xml->errorType("2400", $error_hash[2400]);
    
    if (in_array($verb_value, $g_codes)) 
    {
        return $verb_value;
    } 
    else 
    {   
    //Format error results into XML
    header('Content-type: text/xml');
    echo $xml_return;
    exit();
    }
}


