<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SkillUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\SkillUserAddType;


class SkillUserController extends Controller{
    public function listAction(Request $request){

        $skillUser = new SkillUser();
        $form = $this->createForm(new SkillUserAddType(), $skillUser);
        $form->handleRequest($request);
        $error = false;

        if ($form->isValid()) {
            $user = $this->get('appbundle.repository.user')->loadUserByUsername($this->getUser()->getUsername());
            $skillUser->setUser($user);

            $existSkillUser = $this->get('appbundle.repository.skilluser')->findByUserSkill($user, $skillUser->getSkill());

            if(!$existSkillUser){
                $this->get('appbundle.repository.skilluser')->save($skillUser);
            }else{
                $form->get('skill')->addError(new FormError('Vous avez déjà cette compétence.'));
                $error = true;
            }
        }

        $userSkills = $this->get('appbundle.repository.skilluser')->findByUser($this->getUser());

        return $this->render('AppBundle:SkillUser:list.html.twig', array(
            'userSkills' => $userSkills,
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    public function deleteAction(Request $request){
        $userSkills = $this->get('appbundle.repository.skilluser')->findById($request->get("id"), $this->getUser());
        $this->get('appbundle.repository.skilluser')->delete($userSkills);

        return $this->redirect($this->generateUrl('userSkills'));
    }

    public function editAction(Request $request){
        if($request->get("id")!=""){
            $skillUser = $this->get('appbundle.repository.skilluser')->findById($request->get("id"), $this->getUser());
            $form = $this->createForm(new SkillUserAddType(), $skillUser);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $skillUser = $form->getData();
                $this->get('appbundle.repository.skilluser')->save($skillUser);

                return $this->redirect($this->generateUrl('userSkills'));
            }



            return $this->render('AppBundle:SkillUser:edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('userSkills'));
        }

    }
}