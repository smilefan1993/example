<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class DefaultController extends Controller
{

    /** Rendering main paige of application
     * @Route("/", name="homepage")
     *
     * @return response
     */
    public function indexAction(Request $request)
    {
        $userinfo = new UserInfo();


        return $this->render('mainpage/mainpage.html.twig');
    }

}
