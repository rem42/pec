<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\SkillUser;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSkillUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {
    public function load(ObjectManager $manager){
        $arraySkillUser = [
            'rem42' => [
                'JAVA',
                'ANDROID',
                'JEE',
                'PHP',
                'POO',
                'Symfony',
            ],
            'gouj' => [
                'C++',
                'C',
                'Anglais',
                'Espagnol'
            ],
            'vincent' => [
                'POO',
                'Symfony',
                'HTML',
                'CSS',
                'HTML5',
                'CSS3',
            ],
            'billy' => [
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
                'Communication',
            ]
        ];

        foreach ($arraySkillUser as $a => $b) {
            foreach ($b as $c) {
                $skillUser = new SkillUser();
                $skillUser->setSkill($this->getReference('skill-' . strtolower($c)));
                $skillUser->setUser($this->getReference('user-' . strtolower($a)));
                $skillUser->setDateStart(new \DateTime('NOW'));
                $skillUser->setDateEnd(new \DateTime('NOW'));
                $manager->persist($skillUser);
                $manager->flush();
                $this->addReference('skill-user-'.$a.'-' . strtolower($c), $skillUser);
            }
        }

    }

    public function getOrder(){
        return 4;
    }
}