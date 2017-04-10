<?php

namespace api;

/**
 * Class Response
 * @package api
 */
class Response {
    /**
     * Is method work success
     * @var bool
     */
    public $success = false;

    /**
     * Result of run method
     * @var string
     */
    public $result;

    /**
     * Response constructor.
     * @param bool $success
     * @param $result
     */
    public function __construct(bool $success, $result) {
        $this->success = $success;
        $this->result = (string)$result;
    }
}
