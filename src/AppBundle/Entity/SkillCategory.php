<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SkillCategory {

    protected $id;
    protected $name;

    // Variables de relation
    protected $skills;

    public function __construct() {
        $this->skills = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param ArrayCollection $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }


} 