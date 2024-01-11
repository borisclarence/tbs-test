<?php 
use PHPUnit\Framework\TestCase;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

final class ContactTest extends KernelTestCase
{
    public function getEntity(): Contact
    {
        $contact = new Contact();
        return $contact
            ->setFirstname('John')
            ->setLastname('Jones')
            ->setEmail('jjones@hotmail.ocom');
    }

    public function testValidityEntity()
    {
        $contact = $this->getEntity();
        self::bootKernel();

        $error = self::$container->get('validator')->validate($contact);
        $this->assertCount(0, $error);
    }

    public function testInvalidCodeEntity()
    {
        $contact = (new Contact())
            ->setFirstname('John')
            ->setLastname('Jones')
            ->setEmail('jjones@hotmail.ocom');
        self::bootKernel();
        $error =  self::$container->get('validator')->validate($contact);
        $this->assertCount(1, $error);
    }
}