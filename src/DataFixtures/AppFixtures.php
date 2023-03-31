<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\Collections\ArrayCollection;

class AppFixtures extends Fixture
{
    private const USERS = [
        [
            "login" => "Selene",
            "password" => "admin123",
            "name" => "Karina",
            "email" => "selene@gmail.com",
            "roles" => ["ROLE_SUPERADMIN"]
        ]
    ];

    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
        $this->loadGecks($manager);
        $this->loadReservations($manager);

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach(self::USERS as $userFixture) {
            $user = new User();
            $user->setLogin($userFixture['login']);
            $user->setPassword($userFixture['password']);
            $user->setName($userFixture['name']);
            $user->setEmail($userFixture['email']);
            $user->setRoles($userFixture['roles']);

            $this->addReference('user_' . $userFixture['name'], $user);
            
            $manager->persist($user);
        }
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        for ($i=0; $i<10; $i++)
        {
            $blogPost = new BlogPost();

            $author = $this->getReference('user_' . self::USERS[0]['name']);

            $blogPost->setTitle($this->faker->realText(20));
            $blogPost->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $blogPost->setContent($this->faker->realText(40));
            $blogPost->setSlug($this->faker->slug);
            $blogPost->setAuthor($author);

            $this->setReference("blogPost_" . $i, $blogPost);

            $manager->persist($blogPost);   
        }
    }

    public function loadComments(ObjectManager $manager)
    {
        for ($i=0; $i<10; $i++)
        {
            for ($j=0; $j<rand(0, 5); $j++)
            {
                $comment = new Comment();

                $blogPost = $this->getReference("blogPost_" . $i);

                $comment->setAuthorName($this->faker->name);
                $comment->setBlogPost($blogPost);
                $comment->setContent($this->faker->realText(20));
                $comment->setCreatedAt($this->faker->dateTimeBetween('-1 days'));

                $manager->persist($comment);

            }
        }
    }

    public function loadReservations(ObjectManager $manager)
    {
        for($i=0; $i<20; $i++)
        {
            if($this->faker->boolean(80)) {
                continue;
            }

            $reservation = new Reservation();

            $reservation->setMessage($this->faker->realText(30));
            $reservation->setPhoneNumber($this->faker->e164PhoneNumber);
            $reservation->setEmail($this->faker->email);
            $reservation->setCreatedAt($this->faker->dateTimeBetween('-10 days', 'now'));

            // $gecks = new ArrayCollection();

            for($j=0; $j<20; $j++)
            {
                if($this->faker->boolean(80)) {
                    continue;
                }

                $gecko = $this->getReference("gecko_" . $j);

                if ($gecko->isRequestedForReservation()) {
                    continue;
                }

                $gecko->setRequestedForReservation(1);

                $reservation->addGecko($gecko);

                // $gecks->add($this->getReference("gecko_" . $j));

            }

            /** There are two options of adding gecko references to Reservation Entity:
             *  1. reservation->addGecko(GeckoReference $reference)
             *  2. reservation->setGecks(ArrayCollection $arrayOfReferences)
             */

            // $reservation->setGecks($gecks);

            $manager->persist($reservation);


        }
    }

    public function loadGecks(ObjectManager $manager)
    {
        for($i=0; $i<20; $i++)
        {
            $geckoName = "Gekon " . $this->faker->firstName();
            $gecko = new Gecko();
            $gecko->setName($geckoName);
            $gecko->setSex($this->faker->boolean(50) ? "samiec" : "samica");
            $gecko->setPrice(rand(2, 9) * 100);
            $gecko->setGeckType(rand(1,3));
            $gecko->setReserved(false);
            $gecko->setRequestedForReservation(false);
            $gecko->setFilename(str_replace(" ", "", $geckoName . ".img"));
            $gecko->setCreatedAt($this->faker->dateTimeBetween('-10 days', 'now'));

            $this->setReference("gecko_" . $i, $gecko);

            $manager->persist($gecko);
        }
    }
}
