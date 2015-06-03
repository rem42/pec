<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SkillUserAddType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', 'date')
            ->add('dateEnd', 'date')
            ->add('skill', 'entity', array(
                'class' => 'AppBundle\Entity\Skill',
                'group_by' => 'skillCategory',
                'property' => 'name',
            ))
            ->add('send', 'submit');
    }
    public function getName()
    {
        return 'skillUser';
    }

}