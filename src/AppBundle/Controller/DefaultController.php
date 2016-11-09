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
        $UserValidation = $this->get('security.authorization_checker');

        if($UserValidation->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $CurrentUser = $this->getUser()->getId();
            $UserServices = $this->get('user.helper');
            $ConnectionResult = $UserServices->connectedUsers($CurrentUser);

            if (in_array($id, $ConnectionResult))
                $UserServices->deleteUserConnection($CurrentUser,$id);
            else
                $UserServices->createConnection($CurrentUser,$id);

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
        $UserValidation = $this->get('security.authorization_checker');
        $UserCount = '0';

        if ($UserValidation->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $CurrentUser = $this->getUser()->getId();
            $UserServices = $this->get('user.helper');
            $ListOfUsers = $UserServices->findUsers();
            $ConnectionResult = $UserServices->connectedUsers($CurrentUser);
            $UserCount=count($ConnectionResult);
            return $this->render('mainpage/mainpage.html.twig',array(
                'users'=>$ListOfUsers,
                'ConCount'=> $UserCount,
                'ConResult'=>$ConnectionResult,
            ));

        }
        return $this->render('mainpage/mainpage.html.twig',array(
            'ConCount'=> $UserCount,
        ));
    }

}
