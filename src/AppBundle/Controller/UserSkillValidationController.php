<?php

namespace AppBundle\Controller;


use AppBundle\Entity\UserSkillValidation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserSkillValidationController extends Controller {
    public function validateAction($id){
        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))){
            $user = $this->get('appbundle.repository.user')->loadUserByUsername($this->getUser()->getUsername());
            $skillUser = $this->get('appbundle.repository.skilluser')->loadById($id);
            if ($skillUser->getUser()->getId() == $user->getId()) {
                return new JsonResponse(false);
            }
            $userSkillValidation = new UserSkillValidation();
            $userSkillValidation->setUser($user);
            $userSkillValidation->setUserSkill($skillUser);
            $userSkillValidation->setValidationDate(new \DateTime('NOW'));

            $exist = $this->get('appbundle.repository.userskillvalidation')->findOneByUserSkill($user, $skillUser);
            if (!$exist) {
                $this->get('appbundle.repository.userskillvalidation')->save($userSkillValidation);
                return new JsonResponse(true);
            } else {
                return new JsonResponse(false);
            }
        }else{
            return new JsonResponse(false);
        }
    }
}