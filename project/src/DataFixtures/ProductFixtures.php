<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            1 => [
                'name_product' => 'La Tribune',
                'detail_product' => 'Actualités économiques françaises et internationales',
            ],
            2 => [
                'name_product' => 'Le Figaro',
                'detail_product' => 'Articles de la version papier et ses suppléments',
            ],
            3 => [
                'name_product' => 'Les Echos',
                'detail_product' => 'Actualités économiques françaises et internationales',
            ],
            4 => [
                'name_product' => 'Libération',
                'detail_product' => 'Site tiré de l\'édition papier, étayées de documents multimédia',
            ],
        ];

        foreach($products as $key => $value){
            $product = new Product();

            $product->setNameProduct($value['name_product']);
            $product->setDetailProduct($value['detail_product']);
            $manager->persist($product);

            // Enregistre le produit dans une référence
            $this->addReference('product_' . $key, $product);
        }

        $manager->flush();
    }
}
