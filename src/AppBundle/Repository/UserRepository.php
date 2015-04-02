<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository implements UserProviderInterface{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->entityManager
            ->getRepository("AppBundle:User")
            ->findOneBy(["username" => $username])
        ;

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $refreshedUser = $this->loadUserByUsername($user->getUsername());

        if (null === $refreshedUser) {

            throw new UsernameNotFoundException(sprintf('User with id %s not found', $user->getUsername()));
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return $class === '\AppBundle\Entity\User';
    }

    public function save(User $user){
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

}