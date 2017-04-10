<?php

/**
 * Class PointOfSaleTerminal
 */
class PointOfSaleTerminal {
    public function __construct() {
    }

    private function __clone() {
    }

    /**
     * Array of product prices
     * @var array
     */
    private $prices = [];

    /**
     * User purchases from scan method
     * @var array
     */
    private $purchases = [];

    /**
     * Set pricing for product for SetPrices method
     * @param string $productCode
     * @param int $count
     * @param float $price
     */
    private function setPricing(string $productCode, int $count, float $price) {
        $this->prices[$productCode][$count] = $price;
    }

    /**
     * Return pricing (for test)
     * @return array
     */
    public function getPricing(): array {
        return $this->prices;
    }

    /**
     * Return user purchases (for test)
     * @return array
     */
    public function getPurchases(): array {
        return $this->purchases;
    }

    /**
     * Set price info from array
     * @param array $prices
     */
    public function setPriceByArray(array $prices) {
        foreach ($prices as $price) {
            $this->setPricing($price['productCode'], $price['count'], $price['price']);
        }
    }

    /**
     * Return price for product based of count
     * Also check packs of products
     * @param string $productCode
     * @param int $count
     * @return float
     */
    public function getPriceForProductWithCount(string $productCode, int $count = 1): float {
        $price = 0.0;
        $sumCountFromPack = 0;
        $countInPack = max(array_keys($this->prices[$productCode]));
        if ($count !== 1) {
            $packPrice = $this->prices[$productCode][$countInPack];
            $packsCount = intdiv($count, $countInPack);
            $price += $packsCount * $packPrice;
            $sumCountFromPack = $packsCount * $countInPack;
        }
        $count -= $sumCountFromPack;
        $price += $this->prices[$productCode][1] * $count;
        return $price;
    }

    /**
     * Method for scan products
     * @param string $productCode
     */
    public function scan(string $productCode) {
        $this->purchases[] = $productCode;
    }

    /**
     * Return total price of user purchases
     * @return float
     */
    public function calculateTotal(): float {
        $productCount = [];
        foreach ($this->purchases as $productCode) {
            $productCount[$productCode]++;
        }
        $totalPrice = 0.0;
        foreach ($productCount as $productCode => $count) {
            $totalPrice += $this->getPriceForProductWithCount($productCode, $count);
        }
        return $totalPrice;
    }
}
