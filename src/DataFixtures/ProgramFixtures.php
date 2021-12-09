<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => 'THE WALKING DEAD',
            'year' => '2010',
            'summary' => 'fake news',
            'category' => 'category_0',
            'poster' => 'https://media.senscritique.com/media/000004591491/source_big/The_Walking_Dead.jpg',
            'actors' => ['actor_1', 'actor_2', 'actor_3', 'actor_4']
        ],

        [
            'title' => 'JIM',
            'year' => '2009',
            'summary' => 'hahahahaha',
            'category' => 'category_2',
            'poster' => 'https://media.senscritique.com/media/000004591491/source_big/The_Walking_Dead.jpg',
            'actors' => ['actor_1', 'actor_2']
        ],

        [
            'title' => 'JHON',
            'year' => '2009',
            'summary' => 'hahahahaha',
            'category' => 'category_3',
            'poster' => 'https://media.senscritique.com/media/000004591491/source_big/The_Walking_Dead.jpg',
            'actors' => ['actor_3', 'actor_4']
        ],

        [
            'title' => 'LOU',
            'year' => '2009',
            'summary' => 'hahahahaha',
            'category' => 'category_4',
            'poster' => 'https://media.senscritique.com/media/000004591491/source_big/The_Walking_Dead.jpg',
            'actors' => ['actor_1', 'actor_2']
        ],

        [
            'title' => 'HEY',
            'year' => '2009',
            'summary' => 'hahahahaha',
            'category' => 'category_5',
            'poster' => 'https://media.senscritique.com/media/000004591491/source_big/The_Walking_Dead.jpg',
            'actors' => ['actor_2', 'actor_0']
        ],
    ];

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $programName) {
            $program = new Program();

            $program->setTitle($programName['title']);
            // $program->setYear($programName['year']);
            $program->setSummary($programName['summary']);
            $program->setPoster($programName['poster']);
            $program->setCategory($this->getReference($programName['category']));
            for ($i = 0; $i < count($programName['actors']); $i++) {

                $program->addActor($this->getReference($programName['actors'][$i]));
            }
            $slug = $this->slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
