<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SkillEditType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('skillCategory', 'entity', [
                'class' => 'AppBundle\Entity\SkillCategory',
                'property' => 'name',
            ])
            ->add('send', 'submit');
    }
    public function getName()
    {
        return 'skill';
    }

}