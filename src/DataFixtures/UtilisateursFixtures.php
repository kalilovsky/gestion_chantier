<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Utilisateurs;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UtilisateursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de données fictives
        $faker = Factory::create('FR-fr');
        for ($i = 1; $i <= 30; $i++){
            $utilisateur = new Utilisateurs();
            $utilisateur->setNom($faker->firstName())
                    ->setPrenom($faker->lastName())
                    ->setMatricule((string)$faker->randomNumber(8, true));
            $manager->persist($utilisateur);    
        }
        $manager->flush();
    }
}
