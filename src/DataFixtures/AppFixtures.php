<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\FrontConfig;
use App\Entity\Image;
use App\Entity\Comment;
use App\Entity\Gecko;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private const USERS = [
        [
            "login" => "admin123",
            "password" => "admin123",
            "name" => "Smiling",
            "email" => "example@example.com",
            "roles" => ["ROLE_SUPERADMIN"]
        ]
    ];

    private const IMAGES = 
    [
        [
            "animalId" => 1,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko1.jpg"
        ],
        [
            "animalId" => 2,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko2.jpg"
        ],
        [
            "animalId" => 3,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko3.jpg"
        ],
        [
            "animalId" => 4,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko4.jpg"
        ],
        [
            "animalId" => 5,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko5.jpg"
        ],
        [
            "animalId" => 6,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko6.jpg"
        ],
        [
            "animalId" => 7,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko7.jpg"
        ],
        [
            "animalId" => 8,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko8.jpg"
        ],
        [
            "animalId" => 9,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko9.jpg"
        ],
        [
            "animalId" => 10,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko10.jpg"
        ],
        [
            "animalId" => 11,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko11.jpg"
        ],
        [
            "animalId" => 12,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko12.jpg"
        ],
        [
            "animalId" => 13,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko13.jpg"
        ],
        [
            "animalId" => 14,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko14.jpg"
        ],
        [
            "animalId" => 15,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko15.jpg"
        ],
        [
            "animalId" => 16,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko16.jpg"
        ],
        [
            "animalId" => 17,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko17.jpg"
        ],
        [
            "animalId" => 18,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko18.jpg"
        ],
        [
            "animalId" => 19,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko19.jpg"
        ],
        [
            "animalId" => 20,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko20.jpg"
        ],
        [
            "animalId" => 21,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko21.jpg"
        ],
        [
            "animalId" => 22,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko22.jpg"
        ],
        [
            "animalId" => 23,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko23.jpg"
        ],
        [
            "animalId" => 24,
            "imageType" => "animal",
            "url" => "fixtureImages/gecko24.jpg"
        ],
        [
            "blogPostId" => 1,
            "imageType" => "blogPost",
            "url" => "fixtureImages/blog1.jpg"
        ],
        [
            "blogPostId" => 2,
            "imageType" => "blogPost",
            "url" => "fixtureImages/blog2.jpg"
        ],
        [
            "blogPostId" => 3,
            "imageType" => "blogPost",
            "url" => "fixtureImages/blog3.jpg"
        ],
        [
            "blogPostId" => 4,
            "imageType" => "blogPost",
            "url" => "fixtureImages/blog4.jpg"
        ],
    ];

    protected $faker;
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = Factory::create();
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadFrontConfig($manager);
        $this->loadUsers($manager);
        $this->loadImages($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
        $this->loadGecks($manager);
        $this->loadReservations($manager);

        $manager->flush();
    }
    
    public function loadFrontConfig(ObjectManager $manager)
    {
        $frontConfig = new FrontConfig();
        $manager->persist($frontConfig);
    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach(self::USERS as $userFixture) {
            $user = new User();
            $user->setLogin($userFixture['login']);
            $user->setPassword($this->hasher->hashPassword($user, $userFixture['password']));
            $user->setName($userFixture['name']);
            $user->setEmail($userFixture['email']);
            $user->setRoles($userFixture['roles']);

            $this->addReference('user_' . $userFixture['name'], $user);
            
            $manager->persist($user);
        }
    }

    public function loadImages(ObjectManager $manager) 
    {
        foreach (self::IMAGES as $imageFixture)
        {
            if ($imageFixture["imageType"] == "blogPost") {
                $image = new Image();
                $image->setUrl($imageFixture["url"]);
                $this->setReference("blogPost_" . $imageFixture["url"], $image);
                $manager->persist($image);
            }
        }
        $manager->flush();
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++)
        {
            $blogPost = new BlogPost();

            $author = $this->getReference('user_' . self::USERS[0]['name']);

            $blogPost->setTitle($this->faker->realText(20));
            $blogPost->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $blogPost->setContent($this->faker->realText(40));
            $blogPost->setSlug($this->faker->slug);
            $blogPost->setAuthor($author);

            foreach(self::IMAGES as $image) {
                if (isset($image['blogPostId']) && $image['blogPostId'] == $i) {
                    $blogPost->addImage($this->getReference("blogPost_" . $image["url"]));
                }
            }

            $this->setReference("blogPost_" . $i, $blogPost);

            $manager->persist($blogPost);   
        }
    }

    public function loadComments(ObjectManager $manager)
    {
        for ($i=1; $i<5; $i++)
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
        for($i=1; $i<21; $i++)
        {
            if($this->faker->boolean(80)) {
                continue;
            }

            $reservation = new Reservation();
            $reservation->setUsername($this->faker->userName);
            $reservation->setMessage($this->faker->realText(30));
            $reservation->setPhoneNumber($this->faker->e164PhoneNumber);
            $reservation->setEmail($this->faker->email);
            $reservation->setCreatedAt($this->faker->dateTimeBetween('-10 days', 'now'));
            $reservation->setUniqId(uniqid());

            for($j=1; $j<21; $j++)
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

            }

            $manager->persist($reservation);

        }
    }

    public function loadGecks(ObjectManager $manager)
    {
        for($i=1; $i<25; $i++)
        {
            $gecko = new Gecko();
            $geckoName = "Gekon " . $this->faker->firstName();
            $gecko->setName($geckoName);
            $gecko->setSex($this->faker->boolean(50) ? "samiec" : "samica");
            $gecko->setPrice(rand(2, 9) * 100);
            $gecko->setBreedingNumber(rand(1, 9) . chr(rand(65,90)));
            $gecko->setWeight(rand(8, 30)*10);
            switch ($i) {
                case $i <= 8:
                    $geckoType = 1;
                    break;
                case $i <= 16:
                    $geckoType = 2;
                    break;
                case $i <= 24:
                    $geckoType = 3;
                    break;
            }
            $gecko->setGeckType($geckoType);
            $gecko->setReserved(false);
            foreach(self::IMAGES as $image) {
                if (isset($image['animalId']) && $image['animalId'] == $i) {
                    $gecko->setFilename($image['url']);
                }
            }
            $gecko->setCreatedAt($this->faker->dateTimeBetween('-10 days', 'now'));

            $this->setReference("gecko_" . $i, $gecko);

            $manager->persist($gecko);
        }
    }
}
