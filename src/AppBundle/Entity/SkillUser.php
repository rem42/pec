<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SkillUser {

    protected $id;
    protected $dateStart;
    protected $dateEnd;

    // Variables de relation
    protected $skill;
    protected $user;
    protected $userSkillsValidation;

    public function __construct() {
        $this->userSkillsValidation = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param mixed $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param mixed $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
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
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param mixed $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUserSkillsValidation()
    {
        return $this->userSkillsValidation;
    }

    /**
     * @param mixed $userSkillsValidation
     */
    public function setUserSkillsValidation($userSkillsValidation)
    {
        $this->userSkillsValidation = $userSkillsValidation;
    }

    public function __tostring(){
        return $this->getName();
    }



}