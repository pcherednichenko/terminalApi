<?php

require_once __DIR__ . '/../AbstractMethods.php';
require_once __DIR__ . '/../terminal/PointOfSaleTerminal.php';
require_once __DIR__ . '/../terminal/TerminalFactory.php';

/**
 * Class Scan
 * Method which user use to scan products
 */
class Scan extends AbstractMethods {
    /**
     * Required fields
     */
    const FIELDS = ['productCode'];

    /**
     * @var stdClass
     * Params of request
     */
    private $Params;

    public function __construct(stdClass $Params) {
        $this->Params = $Params;
    }

    public function run() {
        $TerminalInstance = (new TerminalFactory())::getInstance();
        $TerminalInstance->scan($this->Params->productCode);
    }
}
