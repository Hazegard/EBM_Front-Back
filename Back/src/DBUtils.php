<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 15:26
 */

//function fetchToJson($request){
//    return json_encode($request->fetchAll(PDO::FETCH_ASSOC));
//}

function _400(){
    header("HTTP/1.0 400");
    return json_encode(['message'=>"An id must be provided"]);
}