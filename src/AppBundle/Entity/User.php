<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

class User implements UserInterface{
    protected $id;
    protected $name;
    protected $surname;
    protected $mail;
    protected $roles;
    protected $username;
    protected $password;
    protected $salt = "";
    protected $token;
    protected $isActivated;
    protected $isPrivate;
    protected $createdAt;
    protected $updatedAt;

    // Mapping
    protected $userCategory;
    protected $userSkillsValidation;
    protected $skillsUser;

    function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->userSkillsValidation = new ArrayCollection();
        $this->skillsUser = new ArrayCollection();
        $this->token = uniqid("", true);
        $this->isActivated = false;
        $this->isPrivate = false;
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

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
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

    public function getUserSkillsValidation()
    {
        return $this->userSkillsValidation;
    }

    public function setUserSkillsValidation($userSkillsValidation)
    {
        $this->userSkillsValidation = $userSkillsValidation;
    }

    public function getSkillsUser()
    {
        return $this->skillsUser;
    }

    public function setSkillsUser($skillsUser)
    {
        $this->skillsUser = $skillsUser;
    }

    public function getUserCategory()
    {
        return $this->userCategory;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return boolean
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * @param boolean $isPrivate
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;
    }

    /**
     * @return mixed
     */
    public function getIsActivated()
    {
        return $this->isActivated;
    }

    /**
     * @param mixed $isActivated
     */
    public function setIsActivated($isActivated)
    {
        $this->isActivated = $isActivated;
    }

    public function setUserCategory($userCategory)
    {
        $this->userCategory = $userCategory;
    }

    public function eraseCredentials()
    {
        $this->password = null;
    }
}