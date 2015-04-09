<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserCategory;
use AppBundle\Form\Type\UserCategoryAddType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserCategoryController extends Controller{

    public function addAction(Request $request){
        $userCategory = new UserCategory();

        $form = $this->createForm(new UserCategoryAddType(), $userCategory);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $userCategory = $form->getData();
            $this->get('appbundle.repository.user.category')->save($userCategory);

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('@App/UserCategory/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}