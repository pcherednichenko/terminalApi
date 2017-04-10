<?php
namespace api;

use Error;

require_once __DIR__ . '/ApiRequest.php';
require_once __DIR__ . '/Response.php';

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $jsonRequest = file_get_contents('php://input');
    if ($_GET) {
        throw new Error('This is not REST API, this is JSON API');
    }
    $ApiRequest = new ApiRequest($jsonRequest);
    echo json_encode(new Response(true, $ApiRequest->run()));
} catch (Error $Ex) {
    echo json_encode(new Response(false, $Ex));
}
