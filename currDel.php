<?php
//-----------------------------------------------------------------
//--
//--    delCurr by Albert Davies    11/2018
//--
//--    Removes child node from xml file by its 'code' as id
//--    Outputs xml as a string, using the current time stamp
//--    and the requested currency code as a response post deletion
//--
//-----------------------------------------------------------------

function delCurr($ccode, $just_del){

    $xml = new DOMDocument("1.0","UTF-8");
    $xml->load('rates.xml');
    $xpath = new DOMXPath($xml);

    foreach($xpath->query("/currencies/currency[code = '$ccode']") as $node)
    {
        $node->parentNode->removeChild($node);
    }
    $xml->save('rates.xml');

    
    //Outputs formatted XML
    if ($just_del == TRUE)
    {
        $xml->formatOutput = true;  
        $ctime = date('l jS \of F Y h:i:s A');
    
        $xml =  '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<method type="delete">';
        $xml .= '<at>' . $ctime . '</at>';
        $xml .= '<code>' . $ccode . '</code>';
        $xml .= '</method>';
     echo $xml;
    }
}





