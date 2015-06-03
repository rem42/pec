<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Skill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SkillAddType;


class SkillController extends Controller{
    public function listAction(Request $request){

        $skill = new Skill();
        $form = $this->createForm(new SkillAddType(), $skill);
        $form->handleRequest($request);
        $error = false;

        if ($form->isValid()) {
            $this->get('appbundle.repository.skill')->save($skill);
        }

        $skills = $this->get('appbundle.repository.skill')->liste();

        return $this->render('AppBundle:Skill:list.html.twig', array(
            'skills' => $skills,
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    public function deleteAction(Request $request){
        $skill = $this->get('appbundle.repository.skill')->findById($request->get("id"));
        $this->get('appbundle.repository.skill')->delete($skill);

        return $this->redirect($this->generateUrl('addskill'));
    }

    public function editAction(Request $request){
        if($request->get("id")!=""){
            $skill = $this->get('appbundle.repository.skill')->findById($request->get("id"));
            $form = $this->createForm(new SkillAddType(), $skill);
            $form->handleRequest($request);
            $error = false;

            if ($form->isValid()) {
                $this->get('appbundle.repository.skill')->save($skill);
                return $this->redirect($this->generateUrl('addskill'));
            }

            return $this->render('@App/Skill/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('addskill'));
        }
    }
}