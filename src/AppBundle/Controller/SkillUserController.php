<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SkillUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SkillUserAddType;


class SkillUserController extends Controller{
    public function listAction(Request $request){

        $skill = new SkillUser();
        $form = $this->createForm(new SkillUserAddType(), $skill);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $skill = $form->getData();
            $this->get('appbundle.repository.skilluser')->save($skill);

            return $this->redirect($this->generateUrl('skills'));
        }

        $skills = $this->get('appbundle.repository.skilluser')->liste();

        return $this->render('AppBundle:SkillUser:list.html.twig', array(
            'skills' => $skills,
            'form' => $form->createView(),
        ));
    }
}