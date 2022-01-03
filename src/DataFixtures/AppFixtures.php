<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Place;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('user1');
        $user1->setLastName('lastname1');
        $user1->setEmail('name1@gmail.com');
        $password1 = $this->encoder->encodePassword($user1, 'password');
        $user1->setPassword($password1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstName('admin');
        $user2->setLastName('lastname2');
        $user2->setEmail('admin@gmail.com');
        $user2->setRoles(["ROLE_ADMIN"]);
        $password2 = $this->encoder->encodePassword($user2, 'password');
        $user2->setPassword($password2);
        $manager->persist($user2);
       
        
        $place = new Place();
         $place->setName('place1');
         $place->setAdresse('Adresse1');
         $place->setUser($user1);
         $manager->persist($place);

         $place = new Place();
         $place->setName('place2');
         $place->setAdresse('Adresse2');
         $place->setUser($user2);
         $manager->persist($place);
         
         $place = new Place();
         $place->setName('place3');
         $place->setAdresse('Adresse3');
         $place->setUser($user1);
         $manager->persist($place);

        $manager->flush();
    }
}
