<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Skill {

    protected $id;
    protected $name;
    protected $path;
    protected $file; //Not mapped
    private $filenameForRemove; //Not mapped

    // Variables de relation
    protected $skillCategory;
    protected $skillsUser;

    public function __construct() {
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFilenameForRemove()
    {
        return $this->filenameForRemove;
    }

    /**
     * @param mixed $filenameForRemove
     */
    public function setFilenameForRemove($filenameForRemove)
    {
        $this->filenameForRemove = $filenameForRemove;
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


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads';
    }

    public function preUpload()
    {
        if (null !== $this->file) {
            $this->path = $this->file->guessExtension();
        }
    }

    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // vous devez lancer une exception ici si le fichier ne peut pas
        // être déplacé afin que l'entité ne soit pas persistée dans la
        // base de données comme le fait la méthode move() de UploadedFile
        $this->file->move($this->getUploadRootDir(), $this->id.'.'.$this->file->guessExtension());

        unset($this->file);
    }

    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    public function removeUpload()
    {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }
} 