<?php

namespace AppBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProfileController extends BaseController
{
    /**
     * Show the logged user profile
     * @return Response
     */
    public function showAction()
    {
        $user = $this->getUser();
        $userServices = $this->get('user.helper');

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $connectedUsers = $userServices->getOnlyConnectedUsers($user);

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'connectedUsers' => $connectedUsers,
        ));
    }

    /**
     * Generate page for connected user
     * @Route("/profile/{checkingUser}", name="profile")
     * @param User $checkingUser
     * @return Response
     */
    public function otherProfileAction(User $checkingUser)
    {
        $user = $this->getUser();
        $userServices = $this->get('user.helper');

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $connectionResult = $userServices->getOnlyConnectedUsers($user);

        if(!in_array($checkingUser,$connectionResult))
            throw $this->createNotFoundException('Connection with selected user are doesnt exist!');

        return $this->render('FOSUserBundle:Profile:other_user.html.twig', array(
            'username' => $checkingUser->getUsername(),
            'email' => $checkingUser->getEmail(),
        ));
    }
}