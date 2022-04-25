<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // On instancie un objet $faker, du composant FAKERPHP\FAKER.
        // $faker permet de générer des fausses données réalistes. Voir https://fakerphp.github.io/
        $faker = \Faker\Factory::create('fr_FR');

        for ($j = 0; $j < 4; $j++){

            // À chaque tour de boucle on crée une nouvelle catégorie (4 au total)
            $category = new Category();

            $category->setName($faker->sentence())
                    ->setSlug($this->slugger->slug($category->getName()));   

                    $manager->persist($category);

            for ($i = 0; $i <= mt_rand(5, 15); $i++){

                // A chaque tour de boucle on crée une nouvelle instance de notre classe entity Product (un nouveau produit)
                $product = new Product();

                // on insère dans chaque champ de la table product les valeurs du produit grâce aux setter
                $product->setTitle($faker->sentence())
                        ->setContent($faker->realText($faker->numberBetween(10, 20)))
                        ->setPrice(mt_rand(15,35)) // génère des valeurs random de 15 à 35
                        ->setPicture("https://picsum.photos/id/" . mt_rand(10,100) . "/800/500") //mt_rand pour les id de 10 à 100, 200 et 300 pour la taille de l'image
                        ->setCategory($category);

                        $manager->persist($product); // on fait persister les données (on les sauvegarde en tampon, en mémoire vive)
            }
        }
        $manager->flush(); // on les envoie en base de données
    }
}
