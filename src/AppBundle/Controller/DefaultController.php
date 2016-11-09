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
    public function buttonAction($id)
    {
        $userValidation = $this->get('security.authorization_checker');

        if($userValidation->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            $currentUser = $this->getUser()->getId();
            $userServices = $this->get('user.helper');
            $connectionResult = $userServices->connectedUsers($currentUser);

            if (in_array($id, $connectionResult))
                $userServices->deleteUserConnection($currentUser,$id);
            else
                $userServices->createConnection($currentUser,$id);

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
            $currentUser = $this->getUser()->getId();
            $userServices = $this->get('user.helper');
            $listOfUsers = $userServices->findUsers();
            $connectionResult = $userServices->connectedUsers($currentUser);
            $userCount = count($connectionResult);
            return $this->render('mainpage/mainpage.html.twig',array(
                'users'=>$listOfUsers,
                'ConCount'=> $userCount,
                'ConResult'=>$connectionResult,
            ));
        }

        return $this->render('mainpage/mainpage.html.twig',array(
            'ConCount'=>$userCount,
        ));
    }

}
