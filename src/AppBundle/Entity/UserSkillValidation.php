<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


class UserSkillValidation {

    protected $id;
    protected $validationDate;

    //Mapping
    protected $userSkills;
    protected $users;

    public function __construct(){
        $this->userSkills = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getUserSkills()
    {
        return $this->userSkills;
    }

    /**
     * @param ArrayCollection $userSkills
     */
    public function setUserSkills($userSkills)
    {
        $this->userSkills = $userSkills;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }


}