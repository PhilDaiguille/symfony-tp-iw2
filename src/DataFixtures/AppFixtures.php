<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\Season;
use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->setCategory($manager);
        $this->setLanguage($manager);
        $this->setMovie($manager);
    }

    public function setCategory(ObjectManager $manager): void
    {
        $categories = [
            'Action',
            'Adventure',
            'Comedy',
            'Crime',
            'Drama',
            'Fantasy',
            'Historical',
            'Horror',
            'Mystery',
            'Political',
            'Romance',
            'Science Fiction',
            'Thriller',
            'Western',
        ];

        foreach ($categories as $value) {
            $category = new Category();
            $category->setName($value);
            $category->setLabel(strtolower($value));
            $manager->persist($category);
        }

        $manager->flush();
    }

    public function setLanguage(ObjectManager $manager): void
    {
        $languages = [
            'English' => 'en',
            'French' => 'fr',
            'Spanish' => 'es',
            'German' => 'de',
            'Italian' => 'it',
            'Portuguese' => 'pt',
            'Dutch' => 'nl',
            'Russian' => 'ru',
            'Japanese' => 'ja',
            'Chinese' => 'zh',
            'Korean' => 'ko',
            'Arabic' => 'ar',
            'Hindi' => 'hi',
            'Turkish' => 'tr',
        ];

        foreach ($languages as $key => $value) {
            $language = new Language();
            $language->setName($key);
            $language->setCode($value);
            $manager->persist($language);
        }

        $manager->flush();
    }

    public function setMovie(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('Avatar');
        $movie->setLongDescription(
            'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.'
        );
        $movie->setShortDescription(
            'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.'
        );
        $movie->setReleaseDate(new \DateTimeImmutable('2009-12-18'));
        $movie->setCoverImage('https://fr.web.img4.acsta.net/pictures/22/08/25/09/04/2146702.jpg');
        $manager->persist($movie);

        $manager->flush();
    }

    public function setSerie(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $serie = new Serie();
            $serie->setTitle('Avatar');
            $serie->setLongDescription(
                'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.'
            );
            $serie->setShortDescription(
                'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.'
            );
            $serie->setReleaseDate(new \DateTimeImmutable('2009-12-18'));
            $serie->setCoverImage('https://fr.web.img4.acsta.net/pictures/22/08/25/09/04/2146702.jpg');
            $manager->persist($serie);

            for ($j = 0; $j < 10; ++$j) {
                $season = new Season();
                $season->setNumber($j);
                $season->setSerieId($serie->getId());
                $manager->persist($season);

                for ($k = 0; $k < 10; ++$k) {
                    $episode = new Episode();
                    $episode->setTitle('Episode '.$k + 1);
                    $episode->setReleasedAt(new \DateTimeImmutable('2009-12-18'));
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }
}
