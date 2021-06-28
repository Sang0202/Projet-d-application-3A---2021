<?php

namespace App\Controller;

use App\Entity\Inscrit;
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

//FIXME: modifier les atributs correspondants;
class InscriptionController extends AbstractController
{
    
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $User=new User;
        $repo=$em->getRepository(User::class);
        $repoInscrit=$em->getRepository(Inscrit::class);
        $session=new Session;
        if($session->get('role')=="Administrateur"){
            $User=$repo->findAll();
            $Inscrits=$repoInscrit->findAll();
            return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'users'=> $User,
            'inscrits'=> $Inscrits,
        ]);
        }else{
            return $this->redirectToRoute('accueil');
        }
        
    }
    /**
     * @Route("/inscription/create", name="app_inscription_create",methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        $form=$this->createFormBuilder()
            ->add('username',TextType::class,['required'=>true])
            ->add('password',PasswordType::class)
            ->add('email',EmailType::class)
            ->add('role',ChoiceType::class,[
                'choices'=>['Administrateur'=>'Administrateur','Responsable Annee'=>'Responsable Annee','Reponsable Option'=>'Responsable Option','Enseignant'=>'Enseignant']
            ])
            ->add('departement',TextType::class)
            ->add('annee_option',TextType::class)
            ->add('idEnseignant',TextType::class)
            ->add('submit',SubmitType::class, ['label'=>"s'inscrire"])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            //$em->getRepository(User::class);
            $inscrit=new Inscrit;
            $inscrit->setUsername($data['username']);
            $inscrit->setPassword($data['password']);
            $inscrit->setEmail($data['email']);
            $inscrit->setRole($data['role']);
            $inscrit->setDepartement($data['departement']);
            $inscrit->setAnnee($data['annee_option']);
            $inscrit->setIdEnseignant($data['idEnseignant']);


            $em->persist($inscrit);
            $em->flush();
            return new Response('Veuillez attendre que l\'administrateur confirme votre demande');    
        }
        return $this->render('inscription/create.html.twig',
        ['form'=>$form->createView(),
            ]);
    }
    /**
     * @Route("inscription/{id}/edit", name="app_inscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,EntityManagerInterface $em,User $user): Response
    {
        $form = $this->createFormBuilder()
        ->add('name',TextType::class,['data'=>$user->getUsername()])
        ->add('email',EmailType::class,['data'=>$user->getEmail()])
        ->add('role',ChoiceType::class,[
            'choices'=>['admin'=>'admin','Responsable Annee'=>'Responsable Annee','Reponsable Module'=>'Responsable Module']
        ],['data'=>$user->getRole()])
            ->getForm()
            ->add('submit',SubmitType::class, ['label'=>"modifier"])
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $user->setUsername($data['name']);
            $user->setEmail($data['email']);
            $user->setRole($data['role']);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('inscription');
        }
        return $this->render('inscription/edit.html.twig',
            ['form'=>$form->createView(),
                'user'=>$user
                ]);
    }

/**
     * @Route("inscrit/{id}/valider", name="app_inscrit_valider", methods={"GET","POST"})
     */
    public function inscritValider(Request $request,EntityManagerInterface $em,Inscrit $inscrit): Response
    {   
        $User=new User;
        $User->setUsername($inscrit->getUsername());
        $User->setPassword($inscrit->getPassword());
        $User->setEmail($inscrit->getEmail());
        $User->setDepartement($inscrit->getDepartement());
        $User->setAnnee($inscrit->getAnnee());
        $User->setIdEnseignant($inscrit->getIdEnseignant());
        $User->setRole($inscrit->getRole());
        $em->persist($User);
        $em->remove($inscrit);
        $em->flush();
        
        // send email
        
        return $this->redirectToRoute('inscription');
    }

    /**
     * @Route("inscription/{id}/delete", name="app_inscription_delete", methods={"GET","POST"})
     */
    public function delete(Request $request,EntityManagerInterface $em,User $user): Response
    {
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('inscription');
    }

    /**
     * @Route("inscrit/{id}/delete", name="app_inscrit_delete", methods={"GET","POST"})
     */
    public function inscritDelete(Request $request,EntityManagerInterface $em,Inscrit $inscrit): Response
    {
        $em->remove($inscrit);
        $em->flush();
        // send email

        return $this->redirectToRoute('inscription');
    }
}
