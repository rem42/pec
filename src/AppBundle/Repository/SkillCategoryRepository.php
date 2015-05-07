<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SkillCategory;
use Doctrine\ORM\EntityManager;

class SkillCategoryRepository{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function liste(){
        return $this->entityManager->getRepository('AppBundle:SkillCategory')->findAll();
    }

    public function save(SkillCategory $skillCategory){
        $this->entityManager->persist($skillCategory);
        $this->entityManager->flush();
    }

}