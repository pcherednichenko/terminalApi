<?php
use api\ApiRequest;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ApiRequest.php';
require_once __DIR__ . '/../Response.php';

class GetTotalTest extends TestCase {

    public function setUp() {
        (new TerminalFactory())->clearInstance();
    }

    public function testGetTotal() {
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
        (new ApiRequest('{
           "method":"Scan",
           "params": {
             "productCode" : "A"
           }
        }'))->run();
        $purchases = (new TerminalFactory())::getInstance()->getPurchases();
        self::assertEquals($purchases, ['A']);
        $result = (new ApiRequest('{
           "method":"GetTotal"
        }'))->run();
        self::assertEquals(1.25, $result);
    }
}
