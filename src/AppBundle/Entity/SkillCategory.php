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
} 