<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;


class DefaultController extends Controller
{

    /** Action for buttons, adding or delete Connection from DataBase
     * @Route("/pressing/{id}", name="buttonActions" )
     */
    public function buttonAction(User $user)
    {
        $userValidation = $this->get('security.authorization_checker');

        if($userValidation->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $currentUser = $this->getUser();
            $userServices = $this->get('user.helper');
            $connectionResult = $userServices->getConnectedUsers($currentUser);

            if (in_array($user->getId(), $connectionResult))
                $userServices->deleteUserConnection($currentUser,$user);
            else
                $userServices->createConnection($currentUser,$user);

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
            $connectionResult = $userServices->getConnectedUsers($currentUser);
            $userCount = count($connectionResult);
            $paginator = $this->get('knp_paginator');

            if($request->query->get('page'))
                $paginatorPage = $request->query->get('page');
            else
                $paginatorPage = 1;

            $paginator = $paginator->paginate($listOfUsers,$paginatorPage,6);
            return $this->render('mainpage/mainpage.html.twig',array(
                'pagination'=>$paginator,
                'ConCount'=>$userCount,
                'ConResult'=>$connectionResult,
            ));
        }

        return $this->render('mainpage/mainpage.html.twig',array(
            'ConCount'=>$userCount,
        ));
    }

}
