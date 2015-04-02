<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserRegisterType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class UserController extends Controller{

    public function registerAction(Request $request){

        $user = new User();

        $form = $this->createForm(new UserRegisterType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $form->getData();
            $this->get('appbundle.repository.user')->save($user);
            $token = new UsernamePasswordToken($user, null, 'appbundle.repository.user', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('AppBundle:User:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /*public function profileAction(){
        return $this->render('AppBundle:User:profile.html.twig', array());
    }*/
}