<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setFirstName('user1');
        $user1->setLastName('lastname1');
        $user1->setEmail('user@gmail.com');
        $password1 = $this->hasher->hashPassword($user1, 'password');
        $user1->setPassword($password1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setFirstName('admin');
        $user2->setLastName('lastname2');
        $user2->setEmail('admin@gmail.com');
        $user2->setRoles(["ROLE_ADMIN"]);
        $password2 = $this->hasher->hashPassword($user2, 'password');
        $user2->setPassword($password2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setFirstName('producteur');
        $user3->setLastName('lastname3');
        $user3->setEmail('producteur@gmail.com');
        $user3->setRoles(["ROLE_PRODUCTEUR"]);
        $user3->setVille('ville 1');
        $user3->setAdresse('adresse 1');
        $user3->setTelephone('535353535');
        $user3->setValide(true);
        $password3 = $this->hasher->hashPassword($user3, 'password');
        $user3->setPassword($password3);
        $manager->persist($user3);
       
        
        $categorie1 = new Categorie();
        $categorie1->setName('categorie1');
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setName('categorie2');
        $manager->persist($categorie2);

        $produit1 = new Produit();
        $produit1->setName('produit1');
        $produit1->setImage('image1');
        $produit1->setDateRecolte(new \DateTime('2022-03-11'));
        $produit1->setQuantite(5);
        $produit1->setCategorie($categorie1);
        $produit1->setUser($user3);
        $manager->persist($produit1);

        $produit2 = new Produit();
        $produit2->setName('produit2');
        $produit2->setImage('image2');
        $produit2->setDateRecolte(new \DateTime('2022-02-12'));
        $produit2->setQuantite(3);
        $produit2->setCategorie($categorie2);
        $produit2->setUser($user3);
        $manager->persist($produit2);

        $produit3 = new Produit();
        $produit3->setName('produit3');
        $produit3->setImage('image3');
        $produit3->setDateRecolte(new \DateTime('2022-02-06'));
        $produit3->setQuantite(4);
        $produit3->setCategorie($categorie2);
        $produit3->setUser($user3);
        $manager->persist($produit3);

        $manager->flush();
    }
}
