<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Chantiers;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChantiersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('FR-fr');
        for ($i = 1; $i <= 10; $i++){
            $chantier = new Chantiers();
            $chantier->setNom($faker->word())
                    ->setAdresse($faker->address())
                    ->setStartDate($faker->dateTimeBetween('-3 Years'));
            $manager->persist($chantier);    
        }
        $manager->flush();
        $manager->flush();
    }
}
