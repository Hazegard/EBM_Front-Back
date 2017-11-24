<?php
/**
 * Created by PhpStorm.
 * User: maxime
 * Date: 18/11/17
 * Time: 15:26
 */

function _400() {
    http_response_code(400);
    return json_encode(['message'=>"An id must be provided"]);
}