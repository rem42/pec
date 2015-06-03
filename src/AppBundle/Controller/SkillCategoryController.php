<?php
namespace AppBundle\Controller;

use AppBundle\Entity\SkillCategory;
use AppBundle\Form\Type\SkillCategoryAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SkillCategoryController extends Controller{

    public function listAction(Request $request){

        $skillCategory = new SkillCategory();

        $form = $this->createForm(new SkillCategoryAddType(), $skillCategory);
        $form->handleRequest($request);
        $error = false;

        if ($form->isValid()) {
            $this->get('appbundle.repository.skillcategory')->save($skillCategory);
        }

        $skillcategories = $this->get('appbundle.repository.skillcategory')->liste();

        return $this->render('AppBundle:SkillCategory:add.html.twig', array(
            'skillcategories' => $skillcategories,
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    public function deleteAction(Request $request){
        $skillCategory = $this->get('appbundle.repository.skillcategory')->findById($request->get("id"), $this->getUser());
        $this->get('appbundle.repository.skillcategory')->delete($skillCategory);

        return $this->redirect($this->generateUrl('addskillcategory'));
    }

    public function editAction(Request $request){
        if($request->get("id")!=""){
            $skillCategory = $this->get('appbundle.repository.skillcategory')->findById($request->get("id"));
            $form = $this->createForm(new SkillCategoryAddType(), $skillCategory);
            $form->handleRequest($request);
            $error = false;

            if ($form->isValid()) {
                $this->get('appbundle.repository.skillcategory')->save($skillCategory);
                return $this->redirect($this->generateUrl('addskillcategory'));
            }

            return $this->render('@App/SkillCategory/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }else{
            return $this->redirect($this->generateUrl('addskillcategory'));
        }
    }

    /*public function profileAction(){
        return $this->render('AppBundle:User:profile.html.twig', array());
    }*/
}