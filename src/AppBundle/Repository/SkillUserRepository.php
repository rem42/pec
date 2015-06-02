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

    public function findAll(){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findAll();
    }

    public function findByUser(User $user){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findBy(array('user' => $user));
    }

    public function findByUserForTimeline(User $user){
        return $this->entityManager->createQuery(
            'SELECT su, s, sc
            FROM AppBundle:SkillUser su
            LEFT JOIN AppBundle:Skill s WITH su.skill = s.id
            LEFT JOIN AppBundle:SkillCategory sc WITH s.skillCategory = sc.id
            WHERE su.user = :user_id
            '
        )->setParameter(':user_id', $user->getId())->getScalarResult();
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