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
            ->findOneBy(array("username" => $username))
        ;

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        return $user;
    }

    public function loadUserByEmail($email)
    {
        return $this->entityManager
            ->getRepository("AppBundle:User")
            ->findOneBy(array("mail" => $email))
        ;
    }

    public function loadUserById($id){
        $user = $this->entityManager
            ->getRepository("AppBundle:User")
            ->findOneBy(array("id" => $id))
        ;

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.'));
        }

        return $user;
    }

    public function loadUserByToken($token){
        $user = $this->entityManager
            ->getRepository("AppBundle:User")
            ->findOneBy(array("token" => $token))
        ;

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

    public function delete(User $user){
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }


    public function findUsers($string){
        return $this->entityManager->createQuery('SELECT u FROM AppBundle:User u WHERE (u.name LIKE :string OR u.surname LIKE :string OR u.mail LIKE :string) AND u.isPrivate = 0 AND u.isActivated = 1')
            ->setParameter('string',$string.'%')
            ->getArrayResult();
    }
}