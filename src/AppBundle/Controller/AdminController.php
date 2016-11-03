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
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $ListOfUsers = $repository->findAll();
        return $this->render('adminpage/admin.html.twig',[
            'users'=> $ListOfUsers,
        ]);
    }
}
