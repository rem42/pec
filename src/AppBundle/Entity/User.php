<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User {
    protected $id;
    protected $name;
    protected $surname;
    protected $mail;
    protected $nickname;
    protected $password;
    protected $salt = "";
    protected $createdAt;
    protected $updatedAt;

    // Mapping
    protected $userCategory;
    protected $userSkillsValidation;
    protected $skillsUser;

    function __construct()
    {
        $this->userSkillsValidation = new ArrayCollection();
        $this->skillsUser = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIdCategoryUser()
    {
        return $this->idCategoryUser;
    }

    public function setIdCategoryUser($idCategoryUser)
    {
        $this->idCategoryUser = $idCategoryUser;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserSkillsValidation()
    {
        return $this->userSkillsValidation;
    }

    /**
     * @param ArrayCollection $userSkillsValidation
     */
    public function setUserSkillsValidation($userSkillsValidation)
    {
        $this->userSkillsValidation = $userSkillsValidation;
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

    /**
     * @return mixed
     */
    public function getUserCategory()
    {
        return $this->userCategory;
    }

    /**
     * @param mixed $userCategory
     */
    public function setUserCategory($userCategory)
    {
        $this->userCategory = $userCategory;
    }

}