<?php

namespace App\Controller;
use App\Entity\Inscrit;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $repo=$em->getRepository(Inscrit::class);
        $inscrit=$repo->findAll();
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'inscrits'=> $inscrit,
        ]);
    }
    /**
     * @Route("/inscription/create", name="app_inscription_create",methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $inscrit=new Inscrit;
        $form=$this->createFormBuilder($inscrit)
            ->add('name',TextType::class,['required'=>true])
            ->add('submit',SubmitType::class, ['label'=>"s'inscrire"])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($inscrit);
            $em->flush();
            return $this->redirectToRoute('inscription');    
        }
        return $this->render('inscription/create.html.twig',
        ['form'=>$form->createView(),
            ]);
    }
}
