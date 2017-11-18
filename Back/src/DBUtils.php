<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 15:26
 */

function fetchToJson($request){
    return json_encode($request->fetchAll(PDO::FETCH_ASSOC));
}