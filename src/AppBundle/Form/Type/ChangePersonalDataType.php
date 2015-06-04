<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePersonalDataType extends AbstractType{

    private $user;

    public function __construct($user) {

        $this->user = $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('data' => $this->user->getName()))
            ->add('surname', 'text', array('data' => $this->user->getSurname()))
            ->add('username', 'text', array('data' => $this->user->getUsername()))
            ->add('mail', 'email', array('data' => $this->user->getMail()))
            ->add('Modifier mes informations', 'submit')
        ;
    }

    public function getName()
    {
        return 'changePersonalData';
    }
}