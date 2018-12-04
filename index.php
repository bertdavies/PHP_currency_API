<?php
require_once('config.php');


//Switch statement takes in global HTTP array
$method = $_SERVER['REQUEST_METHOD']; 


switch ($method)
{
    case 'POST':
            try
            {
            //Sets up obj to get data from xml file (**FROM** CURRENCY)
            //sets $fromCurrData which returns currency data from xml file as an array
            $fromGetCurr1 = new GetsXml;
            $fromCurrData1 = $fromGetCurr1->getNodes(testUpdateArray($_POST['code'],$g_codes,$error_hash));
            currPost($fromCurrData1[3],testRate($_POST['rate'],$error_hash));              
                
        } catch (Exception $e)
            {
            echo "2500 : ".$error_hash[2500];
            }
    break;


    
    case 'PUT':
        try
            {       
            //inserts a new currency into your data set.
            //curl -X PUT http://xxx -d code=QQQ -d rate=4444 -curr_name=Moneys -d country=England
            //echo "entry point";
            $just_put = TRUE;               
            parse_str(file_get_contents("php://input"),$put_vars);            
            currPut(testCode($put_vars['code'],$error_hash),testRate($put_vars['rate'],$error_hash), $put_vars['curr_name'], testCountry($put_vars['country'],$error_hash),$just_put);

            array_push($g_codes,$put_vars['code']);                    
            //Updates currency code array
            updateArray($g_codes,$put_vars['code']);
                
        } catch (Exception $e)
            {
            echo "2500 : ".$error_hash[2500];
            }
    break;



    case 'DELETE':
        try
            {
            $just_del = TRUE;
            //curl -X DELETE http://xxx -G 'URL' -d 'code=AUD'
            parse_str(file_get_contents("php://input"),$_REQUEST);
            $del_code = implode(" ",$_REQUEST);
                        
               
            delCurr(testUpdateArray($del_code,$g_codes,$error_hash),$just_del);

            $g_codes = array_diff($g_codes, array($del_code));  //remove deleted currencies code from array
            updateArray($g_codes, NULL);
       
        } catch (Exception $e)
            {
            echo "2500 : ".$error_hash[2500];
            }
    break;

  
        
    case 'GET':
        try
            {               
            //Sets up obj to get data from xml file (**FROM** CURRENCY)
            //sets $fromCurrData which returns currency data from xml file as an array
            $fromGetCurr = new GetsXml;   
            $fromCurrData = $fromGetCurr->getNodes($from); 
            //Sets up obj to get data from xml file (**TO** CURRENCY)
            //sets $toCurrData which returns currency data from xml file as an array
            $toGetCurr = new GetsXml;
            $toCurrData = $toGetCurr->getNodes($to); 
            currGet($fromCurrData, $toCurrData, $error_hash, $g_codes);
            
        } catch (Exception $e)
            {
            echo "1500 : ".$error_hash[1500];
            }
    break;



    case 'OPTIONS':
    options();
    break;



    default:

    $xml = new Error;
    $xml_return = $xml->errorType("2000", $error_hash[2000]);

    //Format error results into XML
    header('Content-type: text/xml');
    echo $xml_return;
    exit();

}

