<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Form\is;
use Symfony\Component\Form\type\TaskType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionController extends AbstractController
{
    
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $User=new User;
        $repo=$em->getRepository(User::class);
        //$session=new Session;
        //dd($session->get('role'));
        $User=$repo->findAll();
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'users'=> $User,
        ]);
    }
    /**
     * @Route("/inscription/create", name="app_inscription_create",methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $form=$this->createFormBuilder()
            ->add('name',TextType::class,['required'=>true])
            ->add('password',PasswordType::class)
            ->add('email',EmailType::class)
            ->add('role',ChoiceType::class,[
                'choices'=>['admin'=>'admin','Responsable Annee'=>'Responsable Annee','Reponsable Module'=>'Responsable Module']
            ])
            ->add('submit',SubmitType::class, ['label'=>"s'inscrire"])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            //$em->getRepository(User::class);
            $User=new User;
            $User->setUsername($data['name']);
            $User->setPassword($data['password']);
            $User->setEmail($data['email']);
            $User->setRole($data['role']);
            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute('inscription');    
        }
        return $this->render('inscription/create.html.twig',
        ['form'=>$form->createView(),
            ]);
    }
}
