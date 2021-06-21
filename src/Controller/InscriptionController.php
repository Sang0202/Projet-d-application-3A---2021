<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
    /**
     * @Route("/inscription/create", name="app_inscription_create", methods={"POST"})
     */
    public function create(Request $request,EntityManagerInterface $em):Response
    {
        if($request->isMethod('POST')){
            $data=$request->request->all();       
        }
        return $this->redirect('/inscription');
    }
}
