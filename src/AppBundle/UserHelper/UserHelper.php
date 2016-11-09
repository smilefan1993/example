<?php

namespace AppBundle\UserHelper;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;

class UserHelper
{
    private $repository;
    private $entityManager;

    /**
     * UserHelper constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('AppBundle:User');
    }

    /** Finding all users
     * @return array
     */
    public function findUsers()
    {
        $result = $this->repository->findAll();
        return $result;
    }

    /** Create connection between users
     * @param $user1
     * @param $user2
     */
    public function createConnection($user1,$user2)
    {
        $user1 = $this->repository->findOneBy(array('id'=>$user1));
        $user2 = $this->repository->findOneBy(array('id'=>$user2));
        $user1->addConnect($user2);
        $this->entityManager->flush();
    }

    /** Delete connections
     * @param $user1
     * @param $user2
     */
    public function deleteUserConnection($user1,$user2)
    {
        $user1 = $this->repository->findOneBy(array('id'=>$user1));
        $user2 = $this->repository->findOneBy(array('id'=>$user2));
        $user1->removeConnect($user2);
        $user2->removeConnect($user1);
        $this->entityManager->flush();

    }

    /**
     * @param $user
     * @return array
     */
    public function getConnectedUsers($user)
    {
        return $this->connectedUsers($user);
    }

    /** Find all connect of user
     * @param $connectedUser
     * @return array
     */
    public function connectedUsers($connectedUser)
    {
        $friendsOfUser = $this->entityManager->createQuery('
            SELECT u.id FROM AppBundle:User u
                      JOIN u.friendsWithMe a WHERE a.id=:myid
                ')->setParameter('myid',$connectedUser);
        $listOfUserFriends = $friendsOfUser->getResult();
        $userFriend = $this->entityManager->createQuery('
            SELECT u.id FROM AppBundle:User u
                      JOIN u.myFriends mf WHERE mf.id=:myid
                ')->setParameter('myid',$connectedUser);
        $listOfFriends = $userFriend->getResult();
        $listOfUsers = array();

        foreach($listOfUserFriends as $user){
            $listOfUsers[] = $user['id'];
        }

        foreach($listOfFriends as $friend){
            $listOfUsers[] = $friend['id'];
        }

        return $listOfUsers;
    }
}
