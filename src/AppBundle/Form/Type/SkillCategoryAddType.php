<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SkillCategoryAddType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'label' => 'Nom'
        ])
            ->add('Valider', 'submit', [
                'attr' => [
                    'class' => 'btn-success'
                ]
            ]);
    }
    public function getName()
    {
        return 'skillCategory';
    }

}