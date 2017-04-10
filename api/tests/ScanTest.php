<?php
use api\ApiRequest;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ApiRequest.php';
require_once __DIR__ . '/../Response.php';

class ScanTest extends TestCase {

    public function setUp() {
        (new TerminalFactory())->clearInstance();
    }

    public function testScanProduct() {
        (new ApiRequest('{
           "method":"Scan",
           "params": {
             "productCode" : "A"
           }
        }'))->run();
        $purchases = (new TerminalFactory())::getInstance()->getPurchases();
        self::assertEquals($purchases, ['A']);
    }

    public function testScanManyProducts() {
        (new ApiRequest('{
           "method":"Scan",
           "params": {
             "productCode" : "A"
           }
        }'))->run();
        (new ApiRequest('{
           "method":"Scan",
           "params": {
             "productCode" : "B"
           }
        }'))->run();
        $purchases = (new TerminalFactory())::getInstance()->getPurchases();
        self::assertEquals($purchases, [
            'A',
            'B',
        ]);
    }
}
