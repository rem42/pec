<?php

namespace AppBundle\Repository;

use AppBundle\Entity\UserCategory;
use Doctrine\ORM\EntityManager;


class UserCategoryRepository {
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(UserCategory $userCategory){
        $this->entityManager->persist($userCategory);
        $this->entityManager->flush();
    }

}