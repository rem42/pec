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
            ->findOneBy(["user" => $user, "userSkill" => $skillUser])
            ;
    }

    public function save(UserSkillValidation $userCategory){
        $this->entityManager->persist($userCategory);
        $this->entityManager->flush();
    }

}