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

            $skill = $form->getData();
            $this->get('appbundle.repository.skill')->save($skill);

            return $this->redirect($this->generateUrl(''));
        }

        $skills = $this->get('appbundle.repository.skill')->liste();

        return $this->render('AppBundle:Skill:list.html.twig', array(
            'skills' => $skills,
            'form' => $form->createView(),
        ));
    }
    public function listAction(Request $request){

        $skill = new Skill();
        $form = $this->createForm(new SkillAddType(), $skill);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $skill = $form->getData();
            $this->get('appbundle.repository.skill')->save($skill);

            return $this->redirect($this->generateUrl(''));
        }

        $skills = $this->get('appbundle.repository.skill')->liste();

        return $this->render('AppBundle:Skill:list.html.twig', array(
            'skills' => $skills,
            'form' => $form->createView(),
        ));
    }
}