<?php

require_once __DIR__ . '/../AbstractMethods.php';
require_once __DIR__ . '/../terminal/PointOfSaleTerminal.php';
require_once __DIR__ . '/../terminal/TerminalFactory.php';

/**
 * Class SetPrices
 * Method to set prices of products
 */
class SetPrices extends AbstractMethods {
    /**
     * List of required params
     */
    const FIELDS = ['productsInfo'];

    /**
     * Params of request
     * @var stdClass
     */
    private $Params;

    public function __construct(stdClass $Params) {
        $this->Params = $Params;
    }

    public function run() {
        $TerminalInstance = (new TerminalFactory())::getInstance();
        $ProductsArray = (array)$this->Params->productsInfo;
        foreach ($ProductsArray as $Product) {
            $prices[] = [
                'productCode' => $Product->productCode,
                'count'       => $Product->count,
                'price'       => $Product->price,
            ];
        }
        if (empty($prices)) {
            throw new ParseError('Wrong product info');
        }
        $TerminalInstance->setPriceByArray($prices);
    }
}
