<?php

namespace api;

use AbstractMethods;
use Error;
use stdClass;

require_once __DIR__ . '/methods/Scan.php';
require_once __DIR__ . '/methods/SetPrices.php';
require_once __DIR__ . '/methods/GetTotal.php';
require_once __DIR__ . '/AbstractMethods.php';

/**
 * Class ApiRequest
 * @package api
 */
class ApiRequest {
    /**
     * Did the method work out successfully
     * @var bool
     */
    public $complete = false;

    /**
     * Name of method
     * @var string
     */
    private $method;

    /**
     * Params of request
     * @var stdClass
     */
    private $Params;

    public function __construct($requestJson) {
        $RequestObject = json_decode($requestJson);
        $this->method = $RequestObject->method;
        $this->Params = $RequestObject->params;
    }

    /**
     * Method check params and run logic
     * @return mixed
     * @throws Error
     */
    public function run() {
        try {
            $Method = new $this->method($this->Params);
        } catch (Error $Er) {
            throw new Error('Method ' . $this->method . ' not found');
        }
        if (!$Method instanceof AbstractMethods) {
            throw new Error('Internal error');
        }
        $Method->checkParams($Method::FIELDS, $this->Params);
        $this->complete = true;
        return $Method->run();
    }
}
