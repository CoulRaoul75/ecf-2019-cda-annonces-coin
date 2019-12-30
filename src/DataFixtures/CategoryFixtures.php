<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createCategory("Emploi", 1));
        $manager->persist($this->createCategory("Immobilier", 2));
        $manager->persist($this->createCategory("Loisirs", 3));
        $manager->persist($this->CreateCategory("Maison", 4));
        $manager->persist($this->createCategory("Mode", 5));
        $manager->persist($this->createCategory("Multimédia", 6));
        $manager->persist($this->createCategory("Véhicule", 7));
        $manager->persist($this->createCategory("Autres", 8));

        $manager->flush();
    }

    private function createCategory($titleCategory, $order){
        $category = new Category();
        $category->setTitleCategory($titleCategory);

        $this->addReference("category_$order", $category);

        return $category;

    }
}
