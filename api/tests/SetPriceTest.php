<?php
use api\ApiRequest;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ApiRequest.php';
require_once __DIR__ . '/../Response.php';

class SetPriceTest extends TestCase {

    public function setUp() {
        (new TerminalFactory())->clearInstance();
    }

    public function testSetPrice() {
        (new ApiRequest('{
          "method":"SetPrices",
          "params": {
            "productsInfo" : [{
              "productCode": "A",
              "count": 1,
              "price": 1.25
            }]
          }
        }'))->run();
        $prices = (new TerminalFactory())::getInstance()->getPricing();
        self::assertEquals($prices, [
            'A' => [
                1 => 1.25,
            ],
        ]);
    }

    public function testSetPriceAndPackPrice() {
        (new ApiRequest('{
          "method":"SetPrices",
          "params": {
            "productsInfo" : [{
              "productCode": "A",
              "count": 1,
              "price": 1.25
            }]
          }
        }'))->run();
        (new ApiRequest('{
          "method":"SetPrices",
          "params": {
            "productsInfo" : [{
              "productCode": "A",
              "count": 3,
              "price": 3
            }]
          }
        }'))->run();
        $prices = (new TerminalFactory())::getInstance()->getPricing();
        self::assertEquals($prices, [
            'A' => [
                1 => 1.25,
                3 => 3,
            ],
        ]);
    }

    public function testSetDifferentProducts() {
        (new ApiRequest('{
          "method":"SetPrices",
          "params": {
            "productsInfo" : [{
              "productCode": "A",
              "count": 1,
              "price": 3
            },
            {
              "productCode": "D",
              "count": 1,
              "price": 0.75
            }]
          }
        }'))->run();
        $prices = (new TerminalFactory())::getInstance()->getPricing();
        self::assertEquals($prices, [
            'A' => [
                1 => 3,
            ],
            'D' => [
                1 => 0.75,
            ],
        ]);
    }
}
