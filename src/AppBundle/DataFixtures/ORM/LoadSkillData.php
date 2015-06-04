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
                'C++' => 'png',
                'C' => 'png',
                'JAVA' => 'jpg',
                'ANDROID' => 'png',
                'JEE' => 'png',
                'PHP' => 'png',
                'POO' => 'jpg',
                'Symfony' => 'png',
                'HTML' => 'png',
                'CSS' => 'png',
                'HTML5' => 'png',
                'CSS3' => 'png',
            ],
            'expression' => [
                'Communication' => 'png',
                'Anglais' => 'png',
                'Espagnol' => 'png',
            ]
        ];

        foreach ($arraySkill as $a => $b) {
            foreach ($b as $c => $d) {
                $skill = new Skill();
                $skill->setName($c);
                $skill->setPath($d);
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