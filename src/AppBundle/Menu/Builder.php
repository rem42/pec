<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        //$menu->addChild('Home', array('route' => 'homepage'));

        if($this->container->get('security.context')->isGranted('ROLE_USER')) {
            $menu->addChild('Profil');
            $menu['Profil']->addChild('Deconnexion', array('route' => 'logout'));
        }
        else {
            $menu->addChild('Inscription', array('route' => 'register'));
            $menu->addChild('Connexion', array('route' => 'login'));
        }

        return $menu;
    }
}