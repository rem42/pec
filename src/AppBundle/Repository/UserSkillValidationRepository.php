<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SkillUser;
use AppBundle\Entity\User;
use AppBundle\Entity\UserSkillValidation;
use Doctrine\ORM\EntityManager;


class UserSkillValidationRepository {
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneByUserSkill(User $user, SkillUser $skillUser){
        return $user = $this->entityManager
            ->getRepository("AppBundle:UserSkillValidation")
            ->findOneBy(array("user" => $user, "userSkill" => $skillUser))
            ;
    }

    public function findById($id){
        return $user = $this->entityManager
            ->getRepository("AppBundle:UserSkillValidation")
            ->findBy(array("userSkill" => $id))
            ;
    }

    public function countByUserSkill(SkillUser $skillUser)
    {
        return $this->entityManager->createQuery(
            'SELECT COUNT(usv) as number
            FROM AppBundle:UserSkillValidation usv
            WHERE usv.userSkill = :userSkill_id
            '
        )->setParameter(':userSkill_id', $skillUser->getId())->getSingleResult();
    }

    public function remove(UserSkillValidation $userCategory){
        $this->entityManager->remove($userCategory);
        $this->entityManager->flush();
    }

    public function save(UserSkillValidation $userCategory){
        $this->entityManager->persist($userCategory);
        $this->entityManager->flush();
    }

}