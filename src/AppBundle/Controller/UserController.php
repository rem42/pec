<?php
namespace AppBundle\Controller;

use AppBundle\Entity\SkillUser;
use AppBundle\Form\Type\ChangePersonalDataType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserRegisterType;
use AppBundle\Form\Type\ChangePasswordType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class UserController extends Controller{

    public function registerAction(Request $request){

        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {
            return $this->redirect('home');
        }

        $user = new User();

        $form = $this->createForm(new UserRegisterType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $user = $form->getData();

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            $date = new \DateTime('NOW');
            $user->setCreatedAt($date);
            $user->setUpdatedAt($date);

            $this->get('appbundle.repository.user')->save($user);
            $token = new UsernamePasswordToken($user, null, 'appbundle.repository.user', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('AppBundle:User:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function profileAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $formChangePassword = $this->createForm(new ChangePasswordType());
        $formChangePersonalData = $this->createForm(new ChangePersonalDataType($this->getUser()));

        // Traitement du formulaire pour changer de mot de passe
        if($request->request->has('changePassword')){

            $formChangePassword->handleRequest($request);

            if ($formChangePassword->isValid()) {

                // On récupère les data du formulaure
                $password = $request->request->get('changePassword');

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($password['password']['first'], $user->getSalt());
                $user->setPassword($password);

                $em->merge($user);
                $em->flush();
            }else{
                //d($formChangePassword->getErrorsAsString());
                return $this->redirect($this->generateUrl('home')."#modifier");
            }
        }

        // Traitement du formulaire pour changer les informations personnelles
        if($request->request->has('changePersonalData')){

            $formChangePersonalData->handleRequest($request);

            if ($formChangePersonalData->isValid()) {

                // On récupère les data du formulaure
                $data = $request->request->get('changePersonalData');

                $user->setName($data['name']);
                $user->setSurname($data['surname']);
                $user->setUsername($data['username']);
                $user->setMail($data['mail']);
                $em->merge($user);
                $em->flush();
            }
        }

        return $this->render('AppBundle:User:profil.html.twig', array(
            'formChangePassword' => $formChangePassword->createView(),
            'formChangePersonalData' => $formChangePersonalData->createView(),
        ));
    }

    public function timelineAction()
    {
        $userSkills = $this->get('appbundle.repository.skilluser')->findByUserForTimeline($this->getUser());

        $skills = array();
        foreach ($userSkills as $us) {
            $skills[] = [
                'startDate' => $us["su_dateStart"]->format('d/m/Y h:i:s'),
                'endDate' => $us["su_dateEnd"]->format('d/m/Y h:i:s'),
                'headline' => $us["sc_name"],
                'text' => $us["s_name"].' <a href="" >Valider cette compétence</a>'
            ];
        }
        $timeLine = [
            'timeline' => [
                'headline' => "Cahier des compétences",
                'type' => "default",
                'startDate' => '2010',
                'date' => $skills
            ]
        ];


        return $this->render('AppBundle:User:timeline.html.twig', array(
            'timeLine' => ($timeLine)
        ));
    }

    public function profilePublicAction($id)
    {
        $user = $this->get('appbundle.repository.user')->loadUserById($id);
        $userSkills = $this->get('appbundle.repository.skilluser')->findByUserForTimeline($user);

        $skills = array();
        foreach ($userSkills as $us) {
            $text = $us["s_name"];
            if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER')) && $user->getId() != $this->getUser()->getId()){
                $text .= ' <input type="button" class="validUser btn btn-default" data-url="'.$this->generateUrl('userValidation', array("id"=> $us["su_id"])).'" value="Valider cette compétence" />';
            }
            $skills[] = [
                'startDate' => $us["su_dateStart"]->format('m/d/Y'),
                'endDate' => $us["su_dateEnd"]->format('m/d/Y'),
                'headline' => $us["sc_name"],
                'text' => $text
            ];
        }
        $timeLine = [
            'timeline' => [
                'headline' => "Cahier des compétences",
                'type' => "default",
                'startDate' => '2010',
                'date' => $skills
            ]
        ];

        return $this->render('AppBundle:User:profilePublic.html.twig', array(
            'timeLine' => $timeLine
        ));
    }

    public function searchAction(Request $request){
        $string = $this->getRequest()->request->get('searchText');
        $users = $this->get("appbundle.repository.user")->findUsers($string);

        return new JsonResponse($users);
    }
}