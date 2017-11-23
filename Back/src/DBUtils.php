<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 15:26
 */

function _400() {
    header("HTTP/1.1 400");
    return json_encode(['message'=>"An id must be provided"]);
}