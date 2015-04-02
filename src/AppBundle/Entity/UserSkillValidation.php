<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


class UserSkillValidation
{

    protected $id;
    protected $validationDate;

    //Mapping
    protected $userSkill;
    protected $user;

    public function __construct()
    {
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
    public function getValidationDate()
    {
        return $this->validationDate;
    }

    /**
     * @param mixed $validationDate
     */
    public function setValidationDate($validationDate)
    {
        $this->validationDate = $validationDate;
    }

    /**
     * @return mixed
     */
    public function getUserSkill()
    {
        return $this->userSkill;
    }

    /**
     * @param mixed $userSkill
     */
    public function setUserSkill($userSkill)
    {
        $this->userSkill = $userSkill;
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

}