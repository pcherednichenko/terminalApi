<?php
use api\ApiRequest;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ApiRequest.php';
require_once __DIR__ . '/../Response.php';

class CompleteCyclusTest extends TestCase {
    /**
     * Preparing prices of products
     */
    protected function setUp() {
        (new TerminalFactory())->clearInstance();
        (new ApiRequest('{
          "method":"SetPrices",
          "params": {
            "productsInfo" : [{
              "productCode": "A",
              "count": 1,
              "price": 1.25
            },
            {
              "productCode": "A",
              "count": 3,
              "price": 3
            },
            {
              "productCode": "B",
              "count": 1,
              "price": 4.25
            },
            {
              "productCode": "C",
              "count": 1,
              "price": 1
            },
            {
              "productCode": "C",
              "count": 6,
              "price": 5
            },
            {
              "productCode": "D",
              "count": 1,
              "price": 0.75
            }]
          }
        }'))->run();
    }

    private function sendScanRequests(array $productsCodes) {
        foreach ($productsCodes as $productCode) {
            (new ApiRequest('{
           "method":"Scan",
           "params": {
             "productCode" : "' . $productCode . '"
           }
        }'))->run();
        }
    }

    public function testPurchaseABCDABA() {
        $this->sendScanRequests([
            'A',
            'B',
            'C',
            'D',
            'A',
            'B',
            'A',
        ]);
        $result = (new ApiRequest('{
           "method":"GetTotal"
        }'))->run();
        self::assertEquals(13.25, $result);
    }

    public function testPurchaseCCCCCCC() {
        $this->sendScanRequests([
            'C',
            'C',
            'C',
            'C',
            'C',
            'C',
            'C',
        ]);
        $result = (new ApiRequest('{
           "method":"GetTotal"
        }'))->run();
        self::assertEquals(6, $result);
    }

    public function testPurchaseABCD() {
        $this->sendScanRequests([
            'A',
            'B',
            'C',
            'D',
        ]);
        $result = (new ApiRequest('{
           "method":"GetTotal"
        }'))->run();
        self::assertEquals(7.25, $result);
    }
}
