<?php

/**
 * Class TerminalFactory
 */
class TerminalFactory {
    /**
     * As a data store
     * It is made so for a task, in fact it is necessary to use normal storage
     * @var null
     */
    protected static $instance = null;

    /**
     * @return null|PointOfSaleTerminal
     */
    static public function getInstance() {
        if (self::$instance === null) {
            self::$instance = new PointOfSaleTerminal();
        }
        return self::$instance;
    }

    /**
     * Clear instance for test
     */
    public function clearInstance() {
        self::$instance = null;
    }
}
