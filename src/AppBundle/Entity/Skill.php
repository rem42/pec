<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Skill {

    protected $id;

    protected $name;

    // Variables de relation
    protected $skillCategory;
    protected $skillsUser;

    public function __construct() {
        $this->skillCategory = new ArrayCollection();
        $this->skillsUser = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSkillCategory()
    {
        return $this->skillCategory;
    }

    /**
     * @param mixed $skillCategory
     */
    public function setSkillCategory($skillCategory)
    {
        $this->skillCategory = $skillCategory;
    }

    /**
     * @return ArrayCollection
     */
    public function getSkillsUser()
    {
        return $this->skillsUser;
    }

    /**
     * @param ArrayCollection $skillsUser
     */
    public function setSkillsUser($skillsUser)
    {
        $this->skillsUser = $skillsUser;
    }


} 