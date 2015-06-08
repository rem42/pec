<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRegisterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', ['label' => 'Prénom'])
            ->add('surname', 'text', ['label' => 'Nom'])
            ->add('username', 'text', ['label' => 'Pseudo'])
            ->add('mail', 'email', ['label' => 'Email (celui de Lyon 1)'])
            ->add('password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'options' => ['required' => true],
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Mot de passe (validation)'],
            ])
            ->add('send', 'submit', [
                'label' => "S'enregistrer",
                'attr' => [
                    'class'=>' btn btn-success btn-lg btn-block form'
                ]
            ]);
    }
    public function getName()
    {
        return 'user';
    }

}