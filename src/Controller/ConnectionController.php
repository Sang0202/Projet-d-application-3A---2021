<?php

namespace App\Controller;
use App\Entity\Inscrit;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        $connect=new Inscrit;
        
        $form=$this->createFormBuilder()
        ->add('login',TextType::class)
        ->add('password',PasswordType::class)
        ->add('role',ChoiceType::class,[
            'choices'=>['admin'=>'admin','ResponsableAnne'=>'ResponsableAnne']
        ])
        ->add('connection',SubmitType::class)
        ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           $data=$form->getData();
           if ($data['role']="admin"){
            $repo=$em->getRepository(Inscrit::class);
            $inscrit=$repo->findBy(['name'=>$data['login']]);
            dd($inscrit);
            if ($repo){
            return $this->render('connection/index.html.twig', [
                'controller_name' => 'ConnectionController',
                'form'=>$form->createView(),
                'reponse'=>'valid',]);  
           }
        }
            return $this->render('connection/index.html.twig', [
                'controller_name' => 'ConnectionController',
                'reponse'=>'invalid',
                'form'=>$form->createView(),
            ]);  
        }

        if($request->isMethod('POST')){
            $data=$request->request->all();
           
        }
        return $this->render('connection/index.html.twig', [
            'controller_name' => 'ConnectionController',
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
}
