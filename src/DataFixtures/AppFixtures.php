<?php

// src\DataFixtures\AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Musique;
use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Playlist;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une vingtaine de musiques ayant pour titre
        for ($i = 0; $i < 20; $i++) {
            $musique = new Musique();
            $musique->setNom('Titre: ' . $i);
           

            // Setting the duration as a string in ISO 8601 format (e.g., 'PT3M' for 3 minutes)
            $duration = 'PT3M';
            $musique->setDuree($duration);

            $manager->persist($musique);
        }

        $manager->flush();
    }

    public function load1(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
             // Create Album
            $album = new Album();
            $album->setNom('Sample Album');
            $album->setIdArtiste($artiste);
            $album->addAlbum($musique1);
            $album->addAlbum($musique2);

            // Persist Album
            $manager->persist($album);

            // Flush to save data into database
           
        }
        $manager->flush();

    }

    public function load2(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create Artiste
            $artiste = new Artiste();
            $artiste->setName('Sample Artist');
            $manager->persist($artiste);
        }
        $manager->flush();
    }

    public function load3(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            // Create Playlist
            $playlist = new Playlist();
            $playlist->setNom('Playlist : ');
            $manager->persist($playlist);
        }
        $manager->flush();
    }

    public function load4(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setNom($user);
            $user->setPassword($password);
            $user->setEmail('exemple@mail.com');


        }
        $manager->flush();
    }

}