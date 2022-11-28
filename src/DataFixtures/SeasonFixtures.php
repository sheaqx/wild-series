<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
         * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

        for ($i = 0; $i <= 5; $i++) {
            // je boucle pour preparer 5 saisons par program
            for ($j = 1; $j <= 5; $j++) {
                $season = new Season();
                //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                $season
                    ->setNumber($j)
                    ->setYear($faker->year())
                    ->setDescription($faker->paragraphs(3, true))
                    ->setProgram($this->getReference('program_' . $i));

                $this->setReference('season_' . $j, $season);
                $manager->persist($season);

                for ($k = 1; $k <= 10; $k++) {
                    $episode = new Episode();

                    $episode->setTitle($faker->text(50))
                        ->setNumber($k)
                        ->setSynopsis($faker->paragraphs(3, true))
                        ->setSeason($this->getReference('season_' . $j));
                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
