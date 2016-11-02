<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    private $authmessage = "AdvanceHelloWorld!";
    private $notauthmessage = "HelloWorld!";
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('mainpage/mainpage.html.twig',[
                'message' => $this->notauthmessage,
            ]);
        }else{
            return $this->render('mainpage/mainpage.html.twig',[
                'message' => $this->authmessage,
            ]);
        }

    }



}
