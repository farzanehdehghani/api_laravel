<?php

use App\Helpers\BaseAnswer;

/**
 * @return BaseAnswer
 */
function baseAnswer()
{
    return BaseAnswer::getInstance();
}

function sanitize($string){

    $string = preg_replace('/[^a-zA-Z0-9\']/', '_', $string);
    $string = str_replace("'", '', $string);
    return $string;

}

function convertBashOutputToArray($string){

    $string = preg_split('/\n|\r\n?/', $string);
//    $string = explode('\\n', trim($string));
//    $string= str_replace("\n", "<br />", $string);
    return $string;

}
