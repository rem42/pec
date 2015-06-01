<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {
    public function load(ObjectManager $manager){
        $user = new User();
        $user->setMail("me@rem42.ninja");
        $user->setName('Rémy');
        $user->setSurname('BRUYERE');
        $user->setUsername('rem42');
        $user->setPassword('LhTmnctizH3sjjSmIJ+uzkiLqRUMmVTWnud7idjuzDnDtx5ub7N9LmLKMJFDZiYRZfzaVsu6Y/XcXaGFwhgBSQ==');
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user-rem42', $user);


        $user = new User();
        $user->setMail("remy.goujon@etu.unvi-lyon1.fr");
        $user->setName('Rémy');
        $user->setSurname('GOUJON');
        $user->setUsername('Gouj');
        $user->setPassword('c3xNpXIF9hxIlXu6e3l5p2aIn53AcENgU2y+rk/gta265XTYpvh4QPE75igUl+U/4nRKiqLGL6/K6886OnCi4A==');
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user-gouj', $user);


        $user = new User();
        $user->setMail("vincent.veysset@etu.unvi-lyon1.fr");
        $user->setName('Vincent');
        $user->setSurname('Veysset');
        $user->setUsername('Vincent');
        $user->setPassword('hg6SR5HAv9efHtp5q2pT7DzRnG2x6Rk1AykrtJiblJS/eyCnGDJzG/QDSuYc3rPEK94FaUBen8A+7/rTpSBxzA==');
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user-vincent', $user);


        $user = new User();
        $user->setMail("billy.berthod@gmail.com");
        $user->setName('Billy');
        $user->setSurname('Berthod');
        $user->setUsername('Berthod.Billy');
        $user->setPassword('LbInuPGtIZgPql8wKpFmqeZM4R1XA46EEWzgtKcZ05dG//wtT3/jv9yr/cjfv3XCI+YeUkq2oGGfOZr/rK44Ng==');
        $manager->persist($user);
        $manager->flush();
        $this->addReference('user-billy', $user);
    }

    public function getOrder(){
        return 1;
    }
}