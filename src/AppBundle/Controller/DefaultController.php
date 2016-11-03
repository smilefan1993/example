<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserForm;


class DefaultController extends Controller
{

    /** Rendering main paige of application
     * @Route("/", name="homepage")
     *
     * @return response
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $ListOfUsers = $repository->findAll();
        $form=null;
        foreach($ListOfUsers as $user){
            $form = $this->createForm(UserForm::class,$user);
        }
        $form->handleRequest($request);
        return $this->render('mainpage/mainpage.html.twig', array(
            'form'=>$form->createView(),
            'users'=>$ListOfUsers,
        ));
    }

}
