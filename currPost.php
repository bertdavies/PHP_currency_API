<?php

//-----------------------------------------------------------------
//--
//--    currPost by Albert Davies    11/2018
//--
//--    Updates node values
//--
//--    1. Updates existing xml element
//--    2. Removes old element
//--    3. Adds updated element
//--    4. Outputs response as XML     
//--
//-----------------------------------------------------------------

function currPost($put_code,$put_rate){

//Gets existing currency data and creates Array
$postCurr = new GetsXml;
$postCurrData =  $postCurr->getNodes($put_code); 

//DELETE existing element
delCurr($put_code, FALSE);  //Sets FALSE to xml output function

//Creating new element relating to $put_code with updated rate
currPut($put_code,$put_rate,$postCurrData[0],$postCurrData[1],FALSE);   //Sets FALSE to currPut xml out

//create xml output
    //INDEX
    //0 -   Currency Name
    //1 -   Currency Countries
    //2 -   Rate (against GBP)
    //3 -   CODE
    //4 -   Time stamp

    //Outputs POST request as XML

    function xmlPostOut($postCurrData, $put_rate)
    {

        $xml2 =  '<?xml version="1.0" encoding="UTF-8"?>';
        $xml2 .= '<method type="post">';
        $xml2 .= '<at>' . $postCurrData[4] . '</at>';
        $xml2 .= '<rate>' . $put_rate . '</rate>';
        $xml2 .= '<old_rate>' . $postCurrData[2] . '</old_rate>';
        $xml2 .= '<curr>';
        $xml2 .= '<code>' . $postCurrData[3] . '</code>';
        $xml2 .= '<name>' . $postCurrData[0] . '</name>';
        $xml2 .= '<loc>' . $postCurrData[1] . '</loc>';
        $xml2 .= '</curr>';
        $xml2 .= '</method>';

        echo $xml2;
        //create xml output
    }
    
xmlPostOut($postCurrData, $put_rate);

}


