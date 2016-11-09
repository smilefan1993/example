<?php

namespace AppBundle\UserHelper;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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
        $user1->addConnect($user2);
        $this->entityManager->flush();
    }

    /** Delete connections
     * @param $user1
     * @param $user2
     */
    public function deleteUserConnection($user1,$user2)
    {
        $user1->removeConnect($user2);
        $user2->removeConnect($user1);
        $this->entityManager->flush();
    }

    /** Find all connect of user
     * @param $user
     * @return array
     */
    public function getConnectedUsers($user)
    {
        $result = $user->getConnects();
        $listOfResult = array();

        foreach($result as $res)
            $listOfResult[] = $res->getId();

        return $listOfResult;
    }
}
