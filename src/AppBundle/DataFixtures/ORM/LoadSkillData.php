<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Skill;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSkillData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {
    public function load(ObjectManager $manager){
        $arraySkill = [
            'informatique' => [
                'C++',
                'C',
                'JAVA',
                'ANDROID',
                'JEE',
                'PHP',
                'POO',
                'Symfony',
                'HTML',
                'CSS',
                'HTML5',
                'CSS3',
            ],
            'expression' => [
                'Communication',
                'Anglais',
                'Espagnol'
            ]
        ];

        foreach ($arraySkill as $a => $b) {
            foreach ($b as $c) {
                $skill = new Skill();
                $skill->setName($c);
                $skill->setSkillCategory($this->getReference('skill-category-' . $a));
                $manager->persist($skill);
                $manager->flush();
                $this->addReference('skill-' . strtolower($c), $skill);
            }
        }

    }

    public function getOrder(){
        return 3;
    }
}