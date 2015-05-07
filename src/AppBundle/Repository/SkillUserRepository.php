<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SkillUser;
use Doctrine\ORM\EntityManager;

class SkillUserRepository{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function liste(){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findAll();
    }

    public function save(SkillUser $skill){
        $this->entityManager->persist($skill);
        $this->entityManager->flush();
    }
}