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
        $this->skillsUser = new ArrayCollection();
    }
} 