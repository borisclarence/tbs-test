<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contacts = [
            1 => [
                'firstname' => 'Jeff',
                'lastname' => 'Lantern',
                'email' => 'jlantern@adot.com'
            ],
            2 => [
                'firstname' => 'Hugy',
                'lastname' => 'Winch',
                'email' => 'hugywinch@seyun.com'
            ],
            3 => [
                'firstname' => 'Blondel',
                'lastname' => 'Corgnac',
                'email' => 'bdcorgn@gmail.com'
            ],
            4 => [
                'firstname' => 'Josh',
                'lastname' => 'Jones',
                'email' => 'jjones@hotmail.com'
            ],
        ];

        foreach($contacts as $key => $value){
            $contact = new Contact();

            $contact->setFirstname($value['firstname']);
            $contact->setLastname($value['lastname']);
            $contact->setEmail($value['email']);
            $manager->persist($contact);

            // Enregistre le contact dans une référence
            $this->addReference('contact_' . $key, $contact);
        }

        $manager->flush();
    }
}
