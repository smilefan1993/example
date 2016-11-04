<?php

namespace AppBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;


class DefaultController extends Controller
{

    /** Rendering main paige of application
     * @Route("/", name="homepage")
     *
     * @return response
     */
    public function indexAction(Request $request)
    {
        $uservalidation = $this->get('security.authorization_checker');
        $form = $this->createFormBuilder()->getForm();
        $template = '0';
        if ($uservalidation->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');
            $ListOfUsers = $repository->findAll();
            $currentuser = $this->getUser()->getId();

            //Replace this part into /service!!!!!
            $em= $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT COUNT(u.id) FROM AppBundle:User u 
                         JOIN  u.friendsWithMe');
            //$query->setParameter('myid',$user->getId());
            $results=$query->getResult();
            $results=$query->setMaxResults(1)->getOneOrNullResult();
            //$template=$results[1];
            //
            $seccondquery = $em->createQuery(
                'SELECT u.id FROM AppBundle:User u
                      JOIN u.friendsWithMe a WHERE a.id=:myid
                ')->setParameter('myid',$currentuser);
            $moreresults=$seccondquery->getResult();
            $template=$moreresults[1];
            foreach ($ListOfUsers as $user)
            {
                if ($currentuser != $user->getId())
                {
                    $form
                        ->add($user->getUserName(), FormType::class)
                        ->add($user->getId(), SubmitType::class, array('label' => 'Connect'));
                }
            }

            $form->handleRequest($request);

            if($form->isValid())
            {
                foreach($ListOfUsers as $user)
                {
                    if ($currentuser != $user->getId())
                    {
                        if ($form->get($user->getId())->isClicked())
                        {
                            $entitymanager=$this->getDoctrine()->getManager();
                            $entityrepository=$entitymanager->getRepository('AppBundle:user');
                            $user1=$entityrepository->findOneById($currentuser);
                            $user1->addConnect($user);
                            $entitymanager->flush();

                           // $template=$user->getId();
                        }
                    }
                }
            }
        }
        return $this->render('mainpage/mainpage.html.twig',array(
            'form'=>$form->createView(),
            'template'=> $template,
        ));
    }

}
