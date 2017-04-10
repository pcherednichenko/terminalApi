<?php

require_once __DIR__ . '/../AbstractMethods.php';
require_once __DIR__ . '/../terminal/PointOfSaleTerminal.php';
require_once __DIR__ . '/../terminal/TerminalFactory.php';

/**
 * Class GetTotal
 * Method GetTotal return total price
 */
class GetTotal extends AbstractMethods {

    public function run() {
        $TerminalInstance = (new TerminalFactory())::getInstance();
        return $TerminalInstance->calculateTotal();
    }
}
