<?php
use api\ApiRequest;
use api\Response;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../ApiRequest.php';
require_once __DIR__ . '/../Response.php';

class MainApiTest extends TestCase {

    private function requestSimulation(string $jsonRequest): string {
        try {
            $ApiRequest = new ApiRequest($jsonRequest);
            return json_encode(new Response(true, $ApiRequest->run()));
        } catch (Error $Ex) {
            return json_encode(new Response(false, $Ex));
        }
    }

    public function setUp() {
        (new TerminalFactory())->clearInstance();
    }

    public function testWrongMethod() {
        $result = $this->requestSimulation('{
           "method":"ScanNN",
           "params": {
             "productCode" : "A"
           }
        }');
        self::assertTrue((bool)strpos($result, 'Method ScanNN not found'));
    }

    public function testWrongParams() {
        $result = $this->requestSimulation('{
           "method":"Scan",
           "params": {
             "test" : "A"
           }
        }');
        self::assertTrue((bool)strpos($result, 'ParseError: Required parameter not passed: productCode'));
    }
}
