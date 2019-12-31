<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $nbOfCategory = 8;

        for($i=1; $i <= 100; $i++){
            $ad = new Ad();
            $ad ->setTitle($faker->realText($faker->numberBetween(10,20)))
                ->setText($faker->realText(mt_rand(100, 300)))
                ->setCategory($this->getReference("category_" . mt_rand(1, $nbOfCategory)))
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setPrice($faker->randomNumber(2));

            $this->addReference("ad_$i", $ad);

            $manager->persist($ad);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
        // TODO: Implement getDependencies() method.
    }

    private function createAd($title, $createdAt, $text){
        $ad = new Ad();
        $ad ->setTitle($title)
            ->setCreatedAt($createdAt)
            ->setText($text);
        return $ad;
    }


}
