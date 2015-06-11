<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangeProfileType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isPrivate', 'checkbox', array(
            'label' => " Changer la visibilité de mon profil",
            'required' => false,
        ))
            ->add('Modifier mon profil', 'submit')
        ;
    }
    public function getName()
    {
        return 'changeProfile';
    }

}