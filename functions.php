<?php

class Format
{
    public function xOut($f,$t,$a,$total)   
        {
    //-------------------------------------------------------------------
    //
    //      xOut function is used to reurn a string containing XML data
    //      relivent to the API request
    //      
    //      Takes FROM data array($f), TO array($t), Ammount($a) and 
    //      calculated rate ($total)
    //
    //-------------------------------------------------------------------
            
    //returns array
    //INDEX
    //0 -   Currency Name
    //1 -   Currency Countries
    //2 -   Rate (against GBP)
    //3 -   CODE
    //4 -   Time stamp
           
            $xml =  '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<conv>';
            $xml .= '<at>' . $f[4] . '</at>';
            $xml .= '<rate>' . number_format((float)$f[2], 2, '.', '') . '</rate>';
            $xml .= '<from>';
            $xml .= '<code>' . $f[3] . '</code>';
            $xml .= '<curr>' . $f[0] . '</curr>';
            $xml .= '<loc>' . $f[1] . '</loc>';
            $xml .= '<amnt>' . number_format((float)$a, 2, '.', '') . '</amnt>';
            $xml .= '</from>';
            $xml .= '<to>';
            $xml .= '<code>' . $t[3] . '</code>';
            $xml .= '<curr>' . $t[0] . '</curr>';
            $xml .= '<loc>' . $t[1] . '</loc>';
            $xml .= '<amnt>' . number_format((float)$total, 2, '.', '') . '</amnt>';
            $xml .= '</to>';
            $xml .= '</conv>';       
            return $xml;           
        }
    }

class GetsXml
{
    public function getNodes($nodeCode)
    {
    //-------------------------------------------------------------------
    //
    //      getNodes function finds XML element relating to the currency
    //      code and returns its associated data (siblings) as an array
    //      
    //-------------------------------------------------------------------

    //Innit vars
    $cname = '';
    $cntry = '';
    $crate = '';
               
    $doc = new DOMDocument;
    $doc->load('rates.xml');
    $xpath = new DOMXPath($doc);
              
    //Sets XPath statement and retrns result to variable..
    $xcname = $xpath->query("/currencies/currency[code='$nodeCode']/cname");
    $xcntry = $xpath->query("/currencies/currency[code='$nodeCode']/cntry");
    $xrate = $xpath->query("/currencies/currency[code='$nodeCode']/code/@rate");
        
        
                    foreach ($xcname as $currency)         //Sets Currency Name
                    {
                        $cname = $currency->nodeValue;
                    }
                    foreach ($xcntry as $currency)         //Sets Countries
                    {
                        $cntry = $currency->nodeValue;
                    }
                    foreach ($xrate as $currency)          //Sets Rate
                    {
                        $crate= $currency->nodeValue;
                    }

    //Time stamp for request time
    $ctime = date('l jS \of F Y h:i:s A');

    $node_return = array($cname,$cntry,$crate,$nodeCode,$ctime);
    return $node_return;
    }
}


class Error
{
    public function errorX($e_code, $e_msg)   
        {
    //-------------------------------------------------------------------
    //          *Error message in XML format for currGet
    //-------------------------------------------------------------------  
            $xml =  '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<conv>';
            $xml .= '<error>';
            $xml .= '<code>' . $e_code . '</code>';
            $xml .= '<msg>' . $e_msg . '</msg>';
            $xml .= '</error>';
            $xml .= '</conv>';     
            return $xml;
        }


    public function errorType($e_code, $e_msg)
        {
    //-------------------------------------------------------------------
    //          *Error message in XML format for currPost, Del and Put
    //-------------------------------------------------------------------
            $xml =  '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<method type='.$e_msg.'>';
            $xml .= '<error>';
            $xml .= '<code>' . $e_code . '</code>';
            $xml .= '<msg>' . $e_msg . '</msg>';
            $xml .= '</error>';
            $xml .= '<method>';
            return $xml;
        }
}


//-------------------------------------------------------------------
//          updateArray
//--        Used to update the currency array which is stored in a 
//--        text file server side
//-------------------------------------------------------------------



function updateArray($g_codes,$new_code)
{    
    //Adds new currency code if required...
        if (isset($new_code))
        {
            array_push($g_codes,$new_code);
        }
    //Ouputs appended array to file
    $serializedData = serialize($g_codes);
    file_put_contents('new_rates_array.txt', $serializedData);

    //imports array text file, updates currency code array with it
    $recoveredData = file_get_contents('new_rates_array.txt');
    $g_codes = unserialize($recoveredData);
}
    


//-------------------------------------------------------------------
//          Echos out the API option list
//-------------------------------------------------------------------

function options()
{
    echo "Options list: \n";
    echo "============= \n\n";
    echo "GET: \n";
    echo "---- \n";
    echo "Optional > \n";
    echo "'format'= (xml or json)\n";
    echo "Requires > \n";
    echo "'from'= (ISO currency code)\n";
    echo "'to'= (ISO currency code)\n";
    echo "'amnt'= (Decimel number)\n\n";
    echo "POST: \n";
    echo "---- \n";
    echo "Requires > \n";
    echo "'code'= (ISO currency code)\n";
    echo "'rate'= (Decimel number)\n\n";
    echo "PUT: \n";
    echo "---- \n";
    echo "Requires > \n";
    echo "'code'= (ISO currency code)\n";
    echo "'rate'= (Decimel number)\n";
    echo "'curr_name'= (Xxxx)\n";
    echo "'country'= (Xxxx)\n\n";
    echo "DELETE: \n";
    echo "---- \n";
    echo "Requires > \n";
    echo "'code'= (ISO currency code)\n";
}


