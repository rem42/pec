<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        if(!$this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))){
            $menu->addChild('Connexion', array('route' => 'login'))
                ->setAttribute('icon', 'fa fa-group');
            $menu->addChild('Inscription', array('route' => 'register'))
                ->setAttribute('icon', 'fa fa-list');
        }elseif($this->container->get('security.context')->isGranted(array('ROLE_ADMIN'))){
            $menu->addChild('Compétences', array('route' => 'addskill'));
            $menu->addChild('Catégories de compétences', array('route' => 'addskillcategory'));
        }elseif($this->container->get('security.context')->isGranted(array('ROLE_USER'))){
            $menu->addChild('Ma timeline', array('route' => 'timeline'));
            $menu->addChild('Mes compétences', array('route' => 'userSkills'));
        }

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if($this->container->get('security.context')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) {
            $username = $this->container->get('security.context')->getToken()->getUser()->getUsername(); // Get username of the current logged in user
            $menu->addChild('User', array('label' => 'Hi '.$username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'fa fa-user');

            $menu['User']->addChild('Mon profil', array('route' => 'profil'));
            $menu['User']->addChild('Deconnexion', array('route' => 'logout'))
                ->setAttribute('icon', 'fa fa-sign-out ');
        }


        return $menu;
    }
}