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
        $builder->add('name', 'text', array(
                'data' => $this->user->getName(),
                'label'=> 'Prénom'
        ))
            ->add('surname', 'text', array(
                'data' => $this->user->getSurname(),
                'label'=> 'Nom'
            ))
            ->add('username', 'text', array(
                'data' => $this->user->getUsername(),
                'label'=> 'Pseudo'
            ))
            ->add('mail', 'email', array(
                'data' => $this->user->getMail(),
                'label'=> 'E-mail'
            ))
            ->add('Modifier mes informations', 'submit', array(
                'attr' => array("class" => "btn-success")
            ))
        ;
    }

    public function getName()
    {
        return 'changePersonalData';
    }
}