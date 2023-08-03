<?php
namespace App\Tests\Entity;

use App\Entity\Product;
//use PHPUnit\Framework\TestCase;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testDefault($price,$expectedTVA)
    {
        $product = new Product('Pomme', Product::FOOD_PRODUCT, $price);
        $this->assertSame($expectedTVA, $product->computeTVA());
    }

    public function test2()
    {
        $product = new Product('gsm','phone', 100);
        $this->assertSame(19.6, $product->computeTVA());
    }
    public function testNegativePriceComputeTVA()
    {
        $product = new Product('Un product', Product::FOOD_PRODUCT, -20);
        $this->expectException('Exception');
        $product->computeTVA();
    }
    public function pricesForFoodProduct(): array
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }
}