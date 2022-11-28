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
            'poster' => 'https://www.cdiscount.com/pdt2/5/7/7/1/700x700/auc2009816078577/rw/the-walking-dead-61x91-5cm-affiche-poster.jpg',
            'country' => 'États-Unis',
            'year' => '2010'
        ],
        [
            'title' => 'Vikings',
            'synopsis' => 'Un jeune guerrier viking, est avide d\'aventures et de nouvelles conquêtes',
            'category' => 'Aventure',
            'poster' => 'https://m.media-amazon.com/images/I/61noa0sujTL._AC_SY679_.jpg',
            'country' => 'Canada',
            'year' => '2013'
        ],
        [
            'title' => 'Arcane',
            'synopsis' => 'Deux anciens rivaux s\'affrontent lors d\'un défi spectaculaire qui se révèle fatidique pour Zaun',
            'category' => 'Animation',
            'poster' => 'https://poster-manga.fr/2490-large_default/poster-arcane-affiche-ou-cadre-minimalist.jpg',
            'country' => 'France',
            'year' => '2021'
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Après un été de dix années, un hiver rigoureux s\'abat sur le Royaume avec la promesse d\'un avenir des plus sombres',
            'category' => 'Fantastique',
            'poster' => 'https://static.posters.cz/image/1300/art-photo/game-of-thrones-season-1-key-art-i135455.jpg',
            'country' => 'États-Unis',
            'year' => '2010'
        ],
        [
            'title' => 'American Horror Story',
            'synopsis' => 'American Horror Stories est constituée d\'épisodes indépendants ayant pour thème un univers horrifique qui fait référence à de nombreux faits divers comme des légendes urbaines et des histoires paranormales',
            'category' => 'Horreur',
            'poster' => 'https://pbs.twimg.com/media/Emm2suaXEAEbvDm.jpg:large',
            'country' => 'États-Unis',
            'year' => '2011'
        ],
        [
            'title' => 'The Good Place',
            'synopsis' => 'À sa mort, Eleanor Shellstrop se retrouve au Bon Endroit (en anglais : The Good Place), là où seules les personnes exceptionnelles aux âmes pures arrivent, les autres étant envoyées au Mauvais Endroit. Chaque nouvel arrivant est logé dans une maison idéale, aménagée selon ses goûts, puis fait connaissance avec son âme sœur. Problème, Eleanor n\'est pas vraiment une bonne personne et découvre qu\'elle a été envoyée au Bon Endroit par erreur. Et peu après son arrivée, des choses étranges se produisent...',
            'category' => 'Comedy',
            'poster' => 'https://fr.web.img6.acsta.net/pictures/18/11/26/12/29/3770421.jpg',
            'country' => 'États-Unis',
            'year' => '2016'
        ],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $series) {
            $program = new Program();
            $program->setTitle($series['title']);
            $program->setSynopsis($series['synopsis']);
            $program->setCategory($this->getReference('category_' . $series['category']));
            $program->setPoster($series['poster']);
            $program->setCountry($series['country']);
            $program->setYear($series['year']);
            $manager->persist($program);
            $this->setReference('program_' . $key, $program);
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
