<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SkillUser;
use AppBundle\Entity\SkillCategory;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class SkillUserRepository{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadById($id){
        return $this->entityManager
            ->getRepository("AppBundle:SkillUser")
            ->findOneBy(["id" => $id])
        ;
    }

    public function findById($id, User $user){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findOneBy(array("id"=>$id, "user"=>$user));
    }

    public function findByUserSkill(User $user, Skill $skill){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findOneBy(array("user"=>$user, "skill"=>$skill));
    }

    public function findAll(){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findAll();
    }

    public function findByUser(User $user){
        return $this->entityManager->getRepository('AppBundle:SkillUser')->findBy(array('user' => $user));
    }

    public function findByUserForTimeline(User $user, User $userConnected = NULL){
        if($userConnected){
            return $this->entityManager->createQuery(
                'SELECT su, s, sc, (
                SELECT COUNT(usv2) FROM AppBundle:UserSkillValidation usv2 WHERE usv2.userSkill = su.id
            ) as vote, usv.id
            FROM AppBundle:SkillUser su
            LEFT JOIN AppBundle:Skill s WITH su.skill = s.id
            LEFT JOIN AppBundle:SkillCategory sc WITH s.skillCategory = sc.id
            LEFT JOIN AppBundle:UserSkillValidation usv WITH su.id = usv.userSkill AND usv.user = :user_connected_id
            WHERE su.user = :user_id
            '
            )->setParameter(':user_id', $user->getId())->setParameter(':user_connected_id', $userConnected->getId())->getScalarResult();
        }else{
            return $this->entityManager->createQuery(
                'SELECT su, s, sc, (
                SELECT COUNT(usv2) FROM AppBundle:UserSkillValidation usv2 WHERE usv2.userSkill = su.id
            ) as vote
            FROM AppBundle:SkillUser su
            LEFT JOIN AppBundle:Skill s WITH su.skill = s.id
            LEFT JOIN AppBundle:SkillCategory sc WITH s.skillCategory = sc.id
            WHERE su.user = :user_id
            '
            )->setParameter(':user_id', $user->getId())->getScalarResult();
        }
    }

    public function save(SkillUser $skillUser){
        $this->entityManager->persist($skillUser);
        $this->entityManager->flush();
    }

    public function delete(SkillUser $skillUser){
        $this->entityManager->remove($skillUser);
        $this->entityManager->flush();
    }

    public function findByCategory(User $user){
        return $this->entityManager->createQuery(
            'SELECT sc, s, su
            FROM AppBundle:SkillCategory sc
            JOIN AppBundle:Skill s WITH s.skillCategory = sc.id
            JOIN AppBundle:SkillUser su WITH su.skill = s.id
            WHERE su.user = :user_id
            ')
            ->setParameter(':user_id', $user->getId())->getScalarResult();
    }
}