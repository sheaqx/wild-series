<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        [
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'Action',
        ],
        [
            'title' => 'Vikings',
            'synopsis' => 'Un jeune guerrier viking, est avide d\'aventures et de nouvelles conquêtes',
            'category' => 'Aventure',
        ],
        [
            'title' => 'Arcane',
            'synopsis' => 'Deux anciens rivaux s\'affrontent lors d\'un défi spectaculaire qui se révèle fatidique pour Zaun',
            'category' => 'Animation'
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Après un été de dix années, un hiver rigoureux s\'abat sur le Royaume avec la promesse d\'un avenir des plus sombres',
            'category' => 'Fantastique'
        ],
        [
            'title' => 'American Horror Story',
            'synopsis' => 'American Horror Stories est constituée d\'épisodes indépendants ayant pour thème un univers horrifique qui fait référence à de nombreux faits divers comme des légendes urbaines et des histoires paranormales',
            'category' => 'Horreur'
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programs) {
            $program = new Program();
            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCategory($this->getReference('category_' . $programs['category']));
            $manager->persist($program);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
