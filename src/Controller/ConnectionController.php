<?php

namespace App\Controller;

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
        if($request->isMethod('POST')){
            $data=$request->request->all();
            return $this->render('connection/index.html.twig', [
                'controller_name' => 'ConnectionController',
                'reponse'=>'invalid',
            ]);
        }
        return $this->render('connection/index.html.twig', [
            'controller_name' => 'ConnectionController',
            'reponse'=>'',
        ]);    
        
    }
     /**
     * @Route("/connection", methods={"Post"})
     */
    public function connect2(): Response
    {
    
        //return $this->render('connection/index.html.twig',['controller_name' => 'ConnectionController','reponse'=>'incorrecte',]);
    }
    public function setMdePasse(): Response
    {
    }
}
