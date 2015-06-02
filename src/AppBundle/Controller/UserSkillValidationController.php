<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 02/06/2015
 * Time: 11:30
 */

namespace AppBundle\Controller;


use AppBundle\Entity\UserSkillValidation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserSkillValidationController extends Controller {
    public function validateAction($id){
        $user = $this->get('appbundle.repository.user')->loadUserByUsername($this->getUser());
        $skillUser = $this->get('appbundle.repository.skilluser')->loadById($id);
        $userSkillValidation = new UserSkillValidation();
        $userSkillValidation->setUser($user);
        $userSkillValidation->setUserSkill($skillUser);
        $userSkillValidation->setValidationDate(new \DateTime('NOW'));

        $exist = $this->get('appbundle.repository.userskillvalidation')->findOneByUserSkill($user, $skillUser);
        if(!$exist){
            $this->get('appbundle.repository.userskillvalidation')->save($userSkillValidation);
            return new JsonResponse('true');
        }else{
            return new JsonResponse('false');
        }
    }
}