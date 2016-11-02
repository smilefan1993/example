<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /** Render page of admin user, and finding data to show
     * @Route ("/admin/", name="adminpage")
     *
     * @return response rendering admin page of application
     */
    public function adminController()
    {
        $quee = $this->getDoctrine()->getRepository('AppBundle:User');
        $ListOfUsers = $quee->findAll();
        return $this->render('adminpage/admin.html.twig',[
            'users'=> $ListOfUsers,
        ]);
    }
}
