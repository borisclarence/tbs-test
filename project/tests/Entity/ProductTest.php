<?php 
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Product;
use Symfony\Component\Validator\ConstraintViolation;


final class ProductTest extends KernelTestCase
{
    public function getEntity(): Product
    {
        $product = new Product();
        return $product->setNameProduct('Libération');
    }

    public function testValidityEntity()
    {
        $product = $this->getEntity();
        self::bootKernel();

        $error = self::$container->get('validator')->validate($product);
        $this->assertCount(0, $error);
    }

    public function testInvalidCodeEntity()
    {
        $product = (new Product())
            ->setNameProduct('Libération');
        self::bootKernel();
        $error =  self::$container->get('validator')->validate($product);
        $this->assertCount(1, $error);
    }
}