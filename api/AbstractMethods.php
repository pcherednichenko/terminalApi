<?php

abstract class AbstractMethods {
    /**
     * Required fields
     */
    const FIELDS = [];

    /**
     * Main logic of method must by in run
     * @return mixed
     */
    abstract public function run();

    /**
     * Check required params from array FIELDS
     * @param array $Fields
     * @param $Params
     * @throws ParseError
     */
    public function checkParams(array $Fields, $Params) {
        $paramsArray = array_keys((array)$Params);
        foreach ($Fields as $field) {
            if (!in_array($field, $paramsArray, true)) {
                throw new ParseError('Required parameter not passed: ' . $field);
            }
        }
    }
}
