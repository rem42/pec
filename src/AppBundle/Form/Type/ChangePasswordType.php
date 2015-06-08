<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', 'repeated', [
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'options' => ['required' => true],
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Mot de passe (validation)'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8, 'max' => 20
                    ])
                ]
            ])
            ->add('Modifier mon mot de passe', 'submit', [
                'attr' => ["class" => "btn-success"]
            ])
        ;
    }
    public function getName()
    {
        return 'changePassword';
    }

}