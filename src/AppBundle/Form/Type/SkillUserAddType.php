<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SkillUserAddType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', 'date', [
                'label' => 'Date de début'
            ])
            ->add('dateEnd', 'date', [
                'label' => 'Date de fin'
            ])
            ->add('skill', 'entity', [
                'class' => 'AppBundle\Entity\Skill',
                'group_by' => 'skillCategory',
                'property' => 'name',
                'attr' => [
                    'class' => 'col-md-5'
                ],
                'label' => 'Compétence'
            ])
            ->add('send', 'submit', [
                'attr' => [
                    'class' => 'btn-success'
                ],
                'label' => 'Ajouter'
            ]);
    }
    public function getName()
    {
        return 'skillUser';
    }

}