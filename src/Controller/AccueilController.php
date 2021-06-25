<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        $session=new Session;
        if($session->has('role')){
            return $this->render('accueil/index.html.twig', [
                'controller_name' => 'AccueilController',
                'Username'=>$session->get('Username'),
                'role'=>$session->get('role')
            ]);
        }
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'Username'=>'',
        ]);
        
    }
}
