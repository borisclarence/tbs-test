<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* One */
        $dateStartOne = new \DateTimeImmutable('2023-12-18');
        $dateStartOne->format('Y-m-d H:i:s');

        $dateEndOne = new \DateTimeImmutable('2026-12-18');
        $dateEndOne->format('Y-m-d H:i:s');
        /* One */

        /* Two */
        $dateStartTwo = new \DateTimeImmutable('2024-01-05');
        $dateStartTwo->format('Y-m-d H:i:s');

        $dateEndTwo = new \DateTimeImmutable('2026-01-05');
        $dateEndTwo->format('Y-m-d H:i:s');
        /* Two */
        
        /* Three */
        $dateStartThree = new \DateTimeImmutable('2024-01-08');
        $dateStartThree->format('Y-m-d H:i:s');

        $dateEndThree = new \DateTimeImmutable('2026-01-08');
        $dateEndThree->format('Y-m-d H:i:s');
        /* Three */

        /* Four */
        $dateStartFour = new \DateTimeImmutable('2024-01-11');
        $dateStartFour->format('Y-m-d H:i:s');

        $dateEndFour = new \DateTimeImmutable('2026-01-11');
        $dateEndFour->format('Y-m-d H:i:s');
        /* Four */

        $subscriptions = [
            1 => [
                'contact' => $this->getReference('contact_'. 2),
                'product' => $this->getReference('product_'. 1),
                'date_start' => $dateStartOne,
                'date_end' => $dateEndOne,
            ],
            2 => [
                'contact' => $this->getReference('contact_'. 1),
                'product' => $this->getReference('product_'. 3),
                'date_start' => $dateStartTwo,
                'date_end' => $dateEndTwo,
            ],
            3 => [
                'contact' => $this->getReference('contact_'. 2),
                'product' => $this->getReference('product_'. 2),
                'date_start' => $dateStartThree,
                'date_end' => $dateEndThree,
            ],
            4 => [
                'contact' => $this->getReference('contact_'. 3),
                'product' => $this->getReference('product_'. 4),
                'date_start' => $dateStartFour,
                'date_end' => $dateEndFour,
            ],
        ];

        foreach($subscriptions as $key => $value){
            $subscription = new Subscription();

            $subscription->setProduct($value['product']);
            $subscription->setContact($value['contact']);
            $subscription->setDateStart($value['date_start']);
            $subscription->setDateEnd($value['date_end']);
            $manager->persist($subscription);

            // Enregistre l'abonnement dans une référence
            $this->addReference('subscription_' . $key, $subscription);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContactFixtures::class,
            ProductFixtures::class
        ];
    }
}
