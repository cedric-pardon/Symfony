<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    const EPISODES = [
        [
            'title' => 'Episode 1',
            'synopsis' => 'boumboum',
            'season' => 'season_0',
            'number' => 1
        ],

        [
            'title' => 'Episode 2',
            'synopsis' => 'bambam',
            'season' => 'season_0',
            'number' => 2
        ],

        [
            'title' => 'Episode 3',
            'synopsis' => 'bimbim',
            'season' => 'season_1',
            'number' => 1
        ],

        [
            'title' => 'Episode 4',
            'synopsis' => 'balam',
            'season' => 'season_1',
            'number' => 2
        ],

        [
            'title' => 'Episode 5',
            'synopsis' => 'balambalam',
            'season' => 'season_3',
            'number' => 1
        ]
    ];

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $key => $show) {
            $episode = new Episode();

            $episode->setTitle($show['title']);
            $episode->setSynopsis($show['synopsis']);
            $episode->setNumber($show['number']);
            $episode->setSeason($this->getReference($show['season']));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}