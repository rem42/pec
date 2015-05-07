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

    public function save(SkillUser $skillUser){
        $this->entityManager->persist($skillUser);
        $this->entityManager->flush();
    }

    public function delete(SkillUser $skillUser){
        $this->entityManager->remove($skillUser);
        $this->entityManager->flush();
    }

    public function findById($id){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findOneBy(array("id"=>$id));
    }
}