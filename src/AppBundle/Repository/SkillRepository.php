<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Skill;
use Doctrine\ORM\EntityManager;

class SkillRepository{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function liste(){
        return $this->entityManager->getRepository('AppBundle:Skill')->findAll();
    }

    public function findById($id){
        return $this->entityManager
            ->getRepository("AppBundle:Skill")
            ->findOneBy(array("id" => $id))
            ;
    }

    public function delete(Skill $skill){
        $this->entityManager->remove($skill);
        $this->entityManager->flush();
    }

    public function merge(Skill $skill){
        $this->entityManager->merge($skill);
        $this->entityManager->flush();
    }

    public function save(Skill $skill){
        $this->entityManager->persist($skill);
        $this->entityManager->flush();
    }
}