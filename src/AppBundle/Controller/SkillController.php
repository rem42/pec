<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SkillController extends Controller{
    public function listAction(){

        $skills = $this->get('appbundle.repository.skill')->liste();

        return $this->render('AppBundle:Skill:list.html.twig', array(
            'skills' => $skills,
        ));
    }
}