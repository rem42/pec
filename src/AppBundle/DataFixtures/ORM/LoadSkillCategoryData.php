<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SkillCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSkillCategoryData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {
    public function load(ObjectManager $manager){
        $arraySkillCategory = [
            'Informatique',
            'Expression',
        ];

        foreach ($arraySkillCategory as $a) {
            $skillCategory = new SkillCategory();
            $skillCategory->setName($a);
            $manager->persist($skillCategory);
            $manager->flush();
            $this->addReference('skill-category-'.strtolower($a), $skillCategory);
        }
    }

    public function getOrder(){
        return 2;
    }
}