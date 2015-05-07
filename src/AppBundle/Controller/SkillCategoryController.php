<?php
namespace AppBundle\Controller;

use AppBundle\Entity\SkillCategory;
use AppBundle\Form\Type\SkillCategoryAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SkillCategoryController extends Controller{

    public function addAction(Request $request){

        $skillcategory = new SkillCategory();

        $form = $this->createForm(new SkillCategoryAddType(), $skillcategory);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $skillcategory = $form->getData();
            $this->get('appbundle.repository.skillcategory')->save($skillcategory);

            return $this->redirect($this->generateUrl('home'));
        }

        $skillcategories = $this->get('appbundle.repository.skillcategory')->liste();

        return $this->render('AppBundle:SkillCategory:add.html.twig', array(
            'skillcategories' => $skillcategories,
            'form' => $form->createView(),
        ));
    }

    /*public function profileAction(){
        return $this->render('AppBundle:User:profile.html.twig', array());
    }*/
}