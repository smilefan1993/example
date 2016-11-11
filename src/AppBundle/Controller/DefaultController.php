<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{

    /**
     * Action for buttons, adding or delete Connection from DataBase
     * @Route("/pressing/{id}", name="pressing" )
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function buttonAction(User $user)
    {
        $userValidation = $this->get('security.authorization_checker');

        if($userValidation->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $currentUser = $this->getUser();
            $userServices = $this->get('user.helper');
            $connectionResult = $userServices->getOnlyConnectedUsers($currentUser);

            if (in_array($user, $connectionResult))
                $userServices->deleteUserConnection($currentUser,$user);
            else{
                $userServices->createConnection($currentUser,$user);
                return $this->redirect($this->generateUrl('profile', array('checkingUser'=>$user->getId()),UrlGeneratorInterface::ABSOLUTE_URL));
            }

        }
        return $this->redirectToRoute('homepage');
    }

    /** Rendering main paige of application
     * @Route("/", name="homepage")
     *
     * @return response
     */
    public function indexAction(Request $request)
    {
        $userValidation = $this->get('security.authorization_checker');
        $userCount = 0;

        if ($userValidation->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $currentUser = $this->getUser();
            $userServices = $this->get('user.helper');
            $listOfUsers = $userServices->findUsers();
            //$connectionResult = $userServices->getConnectedUsers($currentUser);
            //$userCount = count($connectionResult);
            $connectionResult = $userServices->getOnlyConnectedUsers($currentUser);
            $userCount = count($connectionResult);
            $paginator = $this->get('knp_paginator');

            if($request->query->get('page'))
                $paginatorPage = $request->query->get('page');
            else
                $paginatorPage = 1;

            $paginator = $paginator->paginate($listOfUsers,$paginatorPage,6);
            return $this->render('mainpage/mainpage.html.twig',array(
                'pagination' => $paginator,
                'ConCount' => $userCount,
                'ConResult' => $connectionResult,
            ));
        }

        return $this->render('mainpage/mainpage.html.twig',array(
            'ConCount' => $userCount,
        ));
    }

}
