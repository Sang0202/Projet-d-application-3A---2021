<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Form\is;
use Symfony\Component\Form\type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    /**
     * @Route("/connection", name="connection")
     */
    public function connect(Request $request,EntityManagerInterface $em): Response
    { 
        $form=$this->createFormBuilder()
        ->add('username',TextType::class)
        ->add('password',PasswordType::class)
        ->add('connection',SubmitType::class)
        ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $repo=$em->getRepository(User::class);
            $User=$repo->findBy(['Username'=>$data['username'],'Password'=>$data['password']]);
            if ($User){

            $session=new Session;
            $session->set('Username',$data['username']);
            $session->set('role',$User['0']->getRole());
            
            return $this->render('accueil/index.html.twig', [  
                'controller_name' => 'AccueilController',         
                'reponse'=>'Connection reusie',
                'Username'=>$session->get('Username'),
            ]);
            }

            return $this->render('connection/index.html.twig', [
                'reponse'=>'invalid',
                'form'=>$form->createView(),
            ]);  
        }

        return $this->render('connection/index.html.twig', [
            'form'=>$form->createView(),
            'reponse'=>'',
        ]);    
        
    }
     /**
     * @Route("/connection", methods={"Post"})
     */
    public function setMdePasse(): Response
    {
    }
    /**
     * @Route("/accueil", name="deconnection", methods={"Post"})
     */
    public function logout(): Response
    {
        $session=new Session;
        $session->clear();
        return $this->render('accueil/index.html.twig',[
            Username=>'',
        ]);
    } 
}
