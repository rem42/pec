<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRegisterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'Prénom'))
            ->add('surname', 'text', array('label' => 'Nom'))
            ->add('username', 'text', array('label' => 'Pseudo'))
            ->add('mail', 'email', array('label' => 'Email'))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'options' => array('required' => true),
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Mot de passe (validation)'),
            ))
            ->add('send', 'submit', array('label' => "S'enregistrer"));
    }
    public function getName()
    {
        return 'user';
    }

}