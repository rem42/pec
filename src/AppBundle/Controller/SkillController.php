<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SkillAddType;


class SkillController extends Controller{
    public function addAction(Request $request){

        $skill = new Skill();
        $form = $this->createForm(new SkillAddType(), $skill);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('appbundle.repository.skill')->save($skill);
        }

        $skills = $this->get('appbundle.repository.skill')->liste();

        return $this->render('AppBundle:Skill:list.html.twig', array(
            'skills' => $skills,
            'form' => $form->createView(),
        ));
    }
}