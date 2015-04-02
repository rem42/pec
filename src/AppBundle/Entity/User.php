<?php

namespace \AppBundle\Entity\User;

class User {
    private $id;
    private $name;
    private $surname;
    private $mail;
    private $nickname;
    private $password;
    private $dateRegister;
    private $dateConnection;
    private $idCategoryUser;

    function __construct()
    {

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

    public function getDateRegister()
    {
        return $this->dateRegister;
    }

    public function setDateRegister($dateRegister)
    {
        $this->dateRegister = $dateRegister;
    }

    public function getDateConnection()
    {
        return $this->dateConnection;
    }

    public function setDateConnection($dateConnection)
    {
        $this->dateConnection = $dateConnection;
    }

    public function getIdCategoryUser()
    {
        return $this->idCategoryUser;
    }

    public function setIdCategoryUser($idCategoryUser)
    {
        $this->idCategoryUser = $idCategoryUser;
    }
}