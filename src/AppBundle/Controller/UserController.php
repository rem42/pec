<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Skill;
use AppBundle\Form\Type\ChangePersonalDataType;
use AppBundle\Form\Type\ChangeProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\UserRegisterType;
use AppBundle\Form\Type\ChangePasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;


class UserController extends Controller{

    public function registerAction(Request $request){

        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {
            return $this->redirect('login');
        }

        $user = new User();

        $form = $this->createForm(new UserRegisterType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {

            if (preg_match('/etu.univ-lyon1/', $user->getMail()) || preg_match('/univ-lyon1/', $user->getMail())) {
                if(!preg_match('/etu.univ-lyon1/', $user->getMail())) {
                    $user->setRoles(array('ROLE_ADMIN'));
                    $user->setIsPrivate(true);
                }
            }
            else {
                $form->get('mail')->addError(new FormError("Vous devez utiliser l'adresse de l'université Lyon 1"));

                return $this->render('AppBundle:User:register.html.twig', array(
                    'form' => $form->createView(),
                ));
            }

            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom($this->get('service_container')->getParameter('mailer_user'))
                ->setTo($user->getMail())
                ->setBody("Validez votre compte avec le lien ci-après :" . $this->generateUrl('public_validation', array('token' => $user->getToken()), true))
            ;
            $validation_account = null;
            if(!$this->get('mailer')->send($message)){
                $user->setIsActivated(true);
                $validation_account = true;
            }

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            $date = new \DateTime('NOW');
            $user->setCreatedAt($date);
            $user->setUpdatedAt($date);

            $this->get('appbundle.repository.user')->save($user);
            //$token = new UsernamePasswordToken($user, null, 'appbundle.repository.user', $user->getRoles());
            //$this->get('security.token_storage')->setToken($token);

            return $this->render('AppBundle:Security:login.html.twig', array(
                'mail_send' => true,
                'validation_account' => $validation_account
            ));
        }

        return $this->render('AppBundle:User:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function profileAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('appbundle.repository.user')->loadUserByUsername($this->getUser()->getUsername());

        $formChangePassword = $this->createForm(new ChangePasswordType());
        $formChangePersonalData = $this->createForm(new ChangePersonalDataType($this->getUser()));
        $formChangeProfile = $this->createForm(new ChangeProfileType());

        $profileUpdate = false;

        // Traitement du formulaire pour changer de mot de passe
        if($request->request->has('changePassword')){

            $formChangePassword->handleRequest($request);

            if ($formChangePassword->isValid()) {

                // On récupère les data du formulaire
                $password = $request->request->get('changePassword');

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($password['password']['first'], $user->getSalt());
                $user->setPassword($password);

                $this->get('appbundle.repository.user')->save($user);

                $profileUpdate = true;
            }else{
                //d($formChangePassword->getErrorsAsString());
                //return $this->redirect($this->generateUrl('profil')."#modifier", [ 'formChangePassword' => $formChangePassword->createView()]);
            }
        }

        // Traitement du formulaire pour changer les informations personnelles
        if($request->request->has('changePersonalData')){

            $formChangePersonalData->handleRequest($request);

            if ($formChangePersonalData->isValid()) {

                // On récupère les data du formulaire
                $data = $request->request->get('changePersonalData');

                $user->setName($data['name']);
                $user->setSurname($data['surname']);
                $user->setUsername($data['username']);
                $user->setMail($data['mail']);

                $this->get('appbundle.repository.user')->save($user);

                $profileUpdate = true;
            }
        }

        // Traitement du formulaire pour changer le profil
        if($request->request->has('changeProfile')){

            $formChangeProfile->handleRequest($request);

            if ($formChangeProfile->isValid()) {

                // On récupère les data du formulaire
                $data = $request->request->get('changeProfile');

                if(!empty($data['isPrivate'])) {
                    if($user->getIsPrivate()) {
                        $user->setIsPrivate(false);
                    }
                    else {
                        $user->setIsPrivate(true);
                    }
                }

                $this->get('appbundle.repository.user')->save($user);

                $profileUpdate = true;
            }
        }

        return $this->render('AppBundle:User:profil.html.twig', array(
            'formChangePassword' => $formChangePassword->createView(),
            'formChangePersonalData' => $formChangePersonalData->createView(),
            'formChangeProfil' => $formChangeProfile->createView(),
            'profileUpdate' => $profileUpdate,
            'profileState' => $user->getIsPrivate(),
        ));
    }

    public function deleteAction(){

        $user = $this->get('appbundle.repository.user')->loadUserByUsername($this->getUser()->getUsername());

        $this->get('appbundle.repository.user')->delete($user);

        return $this->redirect($this->generateUrl('logout'));
    }

    public function profilePublicAction(Request $request)
    {
        if($request->get('id')){
            $user = $this->get('appbundle.repository.user')->loadUserById($request->get('id'));
        }else{
            $user = $this->get('appbundle.repository.user')->loadUserById($this->getUser()->getId());
        }

        if($user->getIsPrivate()) {
            return $this->redirect($this->generateUrl('login'));
        }

        $userSkills = $this->get('appbundle.repository.skilluser')->findByUserForTimeline($user, $this->getUser());

        $skills = array();
        foreach ($userSkills as $us) {
            $skill = new Skill();
            $skill->setId($us["s_id"]);
            $skill->setPath($us["s_path"]);
            $text = "";
            if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))){
                if(method_exists($this->getUser(), 'getId') && $user->getId() != $this->getUser()->getId()) {
                    if(isset($us["id"]) && $us["id"]>0){
                        $text .= ' <input
                    type="button"
                    class="validUser btn btn-success checked"
                    data-url="' . $this->generateUrl('userValidation', array("id" => $us["su_id"])) . '"
                    value="+1" /> <img id="loading" src="'.$this->container->get('templating.helper.assets')->getUrl('bundles/app/css/timeline/loading.gif').'" />';
                    }else{
                        $text .= ' <input
                    type="button"
                    class="validUser btn btn-info"
                    data-url="' . $this->generateUrl('userValidation', array("id" => $us["su_id"])) . '"
                    value="+1" /> <img id="loading" src="'.$this->container->get('templating.helper.assets')->getUrl('bundles/app/css/timeline/loading.gif').'" />';
                    }
                }
            }
            $text .= '<span class="badge" data-url="'.$this->generateUrl('profil_public_info', array("id" => $us["su_id"])).'">'.$us["vote"].'</span>';
            $skills[] = array(
                'startDate' => $us["su_dateStart"]->format('m/d/Y'),
                'endDate' => $us["su_dateEnd"]->format('m/d/Y'),
                'text' => $us["sc_name"].$text,
                'headline' => $us["s_name"],
                'asset' => array(
                    'media' => $skill->getWebPath(),
                    'thumbnail' => $skill->getWebPath(),
                )
            );
        }
        $timeLine = array(
            'timeline' => array(
                'headline' => "Cahier des compétences",
                'type' => "default",
                'startDate' => '2010',
                'date' => $skills
            )
        );

        return $this->render('AppBundle:User:profilePublic.html.twig', array(
            'timeLine' => $timeLine,
            'user' => $user
        ));
    }

    public function searchAction(Request $request){
        $string = $this->getRequest()->request->get('searchText');
        $users = $this->get("appbundle.repository.user")->findUsers($string);

        return new JsonResponse($users);
    }

    public function validationAction(Request $request, $token){

        $user = $this->get('appbundle.repository.user')->loadUserByToken($token);

        if($user) {
            $user->setToken(null);
            $user->setIsActivated(true);
            $this->get('appbundle.repository.user')->save($user);
            $validation_account = true;
        }
        else {
            $validation_account = false;
        }
        return $this->render('AppBundle:Security:login.html.twig', array(
            'validation_account' => $validation_account
        ));
    }

    public function lostPasswordAction(Request $request){

        $user = $this->get('appbundle.repository.user')->loadUserByEmail($request->get('email'));
        if($user) {

            $message = \Swift_Message::newInstance()
                ->setSubject("Demande d'un nouveau mot de passe")
                ->setFrom($this->get('service_container')->getParameter('mailer_user'))
                ->setTo($user->getMail())
                ->setBody("Validez votre compte avec le lien ci-après :" . $this->generateUrl('public_new_password', array('token' => $user->getToken()), true))
            ;
            if(!$this->get('mailer')->send($message)){

            }

            $user->setToken(uniqid("", true));
            $this->get('appbundle.repository.user')->save($user);
        }
        else {

            return new Response(false);
        }

        return new Response(true);
    }

    public function newPasswordAction(Request $request, $token){

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('appbundle.repository.user')->loadUserByToken($token);

        if($user) {

            $formChangePassword = $this->createForm(new ChangePasswordType());
            $formChangePassword->handleRequest($request);

            if ($formChangePassword->isValid()) {

                if ($formChangePassword->isValid()) {

                    // On récupère les data du formulaire
                    $password = $request->request->get('changePassword');

                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($password['password']['first'], $user->getSalt());
                    $user->setPassword($password);
                    $user->setToken(null);

                    $em->merge($user);
                    $em->flush();
                }
                return $this->render('AppBundle:Security:login.html.twig', array(
                    'new_password_defined' => true,
                ));
            }
            return $this->render('AppBundle:User:newPassword.html.twig', array(
                'formChangePassword' => $formChangePassword->createView(),
            ));
        }
        else {
            return $this->redirect($this->generateUrl('login'));
        }
    }
}