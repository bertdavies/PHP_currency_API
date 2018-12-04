<?php
//-----------------------------------------------------------------
//--
//--    currPut by Albert Davies    11/2018
//--
//--    Adds new XML node
//--
//--    1. Loads XML file to memory
//--    2. Appends a node to the end of the file in memory
//--    3. Overwrites rates.xml with new appended rates file
//--    4. If required, outputs XML response
//--
//-----------------------------------------------------------------

function currPut($put_code,$put_rate,$put_curr_name,$put_curr_country,$just_put){


    $xmlput = new DOMDocument("1.0","UTF-8");
    $xmlput->load('rates.xml');
    

    
    $rootTag = $xmlput->getElementsByTagName("currencies")->item(0);

    $currencyTag = $xmlput->createElement("currency");
        
        $codeNode = $xmlput->createElement("code", $put_code);
        $codeNode->setAttribute('rate', $put_rate);
        $cnameNode = $xmlput->createElement("cname", $put_curr_name);
        $cntryNode = $xmlput->createElement("cntry", $put_curr_country);
        
        $currencyTag->appendChild($codeNode);
        $currencyTag->appendChild($cnameNode);
        $currencyTag->appendChild($cntryNode);        
        $rootTag->appendChild($currencyTag);
        
        $xmlput->save('rates.xml');  //UPDATE rates.xml


//create xml output
    //INDEX
    //0 -   Currency Name
    //1 -   Currency Countries
    //2 -   Rate (against GBP)
    //3 -   CODE
    //4 -   Time stamp

    //Condition to only return the XML if requested
    if ($just_put == TRUE)
    {
        $ctime = date('l jS \of F Y h:i:s A');

    $xml =  '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<method type="PUT">';
    $xml .= '<at>' . $ctime . '</at>';
    $xml .= '<rate>' . $put_rate . '</rate>';
    $xml .= '<curr>';
    $xml .= '<code>' . $put_code . '</code>';
    $xml .= '<name>' . $put_curr_name . '</name>';
    $xml .= '<loc>' . $put_curr_country . '</loc>';
    $xml .= '</curr>';
    $xml .= '</method>';

    echo $xml;
    }
}






