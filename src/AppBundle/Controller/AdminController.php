<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller {
    private $check='its a check text';


    /**
     * @Route ("/admin/", name="adminpage")
     */
    public function adminController(){
        $quee = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $quee->findAll();
        return $this->render('adminpage/admin.html.twig',[
            'users'=> $users,
        ]);
    }
}
