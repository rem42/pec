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
            /*p($skillUser->getUser()->getId());
            d($user->getId());*/
            if ($skillUser->getUser()->getId() == $user->getId()) {
                return new JsonResponse(false);
            }
            $userSkillValidation = new UserSkillValidation();
            $userSkillValidation->setUser($user);
            $userSkillValidation->setUserSkill($skillUser);

            $exist = $this->get('appbundle.repository.userskillvalidation')->findOneByUserSkill($user, $skillUser);
            if (!$exist) {
                $userSkillValidation->setValidationDate(new \DateTime('NOW'));
                $this->get('appbundle.repository.userskillvalidation')->save($userSkillValidation);
                $status = true;
            } else {
                $this->get('appbundle.repository.userskillvalidation')->remove($exist);
                $status = false;
            }
            $count = $this->get('appbundle.repository.userskillvalidation')->countByUserSkill($skillUser);
            return new JsonResponse(array('status' => $status, 'count' => $count["number"]));
        }else{
            return new JsonResponse(false);
        }
    }

    public function infoAction(Request $request){
        if($request->get("id")!=""){
            $userSkillValidations = $this->get('appbundle.repository.userskillvalidation')->findById($request->get("id"));
            $name = array();
            foreach ($userSkillValidations as $usv) {
                $name[] = $usv->getUser()->getName().' '.$usv->getUser()->getSurname();
            }
            if(sizeof($name)>0){
                return new JsonResponse(array('person' => $name));
            }else{
                return new JsonResponse(false);
            }

        }
        return new JsonResponse(false);
    }
}