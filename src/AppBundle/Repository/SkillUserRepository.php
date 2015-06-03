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

    public function findByCategory(User $user){
        /*$query = $this->entityManager->getConnection()->prepare(
            'SELECT sc.id, sc.name, s.id, s.name, su.id
            FROM skill_user su
            JOIN skill s ON s.id = su.skill_id
            JOIN skill_category sc ON s.skill_category_id = sc.id
            WHERE su.user_id = :user_id
            '
        );
        $query->execute(
            array(
                'user_id', $user->getId()
            )
        );
        return $query->fetchAll();*/

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
/*'SELECT sc.id, sc.name, s.id, s.name, su.id
            FROM skill_category sc
            JOIN skill s ON s.skill_category_id = sc.id
            JOIN skill_user su ON s.id = su.skill_id
            WHERE su.user_id = :user_id
            '*/
/*
            'SELECT sc, s, su
            FROM AppBundle:SkillCategory sc
            JOIN AppBundle:Skill s WITH s.id = sc.skills
            JOIN AppBundle:SkillUser su WITH s.skillsUser = su.id
            WHERE su.user = :user_id
            '*/