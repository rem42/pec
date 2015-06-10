<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SkillEditType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'label' => 'Nom',
            ])
            ->add('skillCategory', 'entity', [
                'class' => 'AppBundle\Entity\SkillCategory',
                'property' => 'name',
                'label' => 'Catégorie',
            ])
            ->add('Modifier', 'submit', [
                'attr' => [
                    'class' => 'btn-success'
                ]
            ]);
    }
    public function getName()
    {
        return 'skill';
    }

}