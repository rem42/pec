<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SkillUser;
use AppBundle\Entity\User;
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

    public function findById($id, User $user){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findOneBy(array("id"=>$id, "user"=>$user));
    }
}