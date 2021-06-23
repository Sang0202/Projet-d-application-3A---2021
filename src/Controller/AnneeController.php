<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnneeController extends AbstractController
{
    /** 
     * @Route("/{departement}/{annee}", name="departement_annee")
     */

    public function annee($departement, $annee)
    {
        // $departement = ['STI', 'MRI', 'ERE'];
        // $semestre = ['S5', 'S6', 'S7', 'S8', 'S9', 'S10', ]
        // return new Response(sprintf('This is %s du STI',$annee));

        switch ($departement) {
            case 'STI':
                switch ($annee) {
                    case '3A':
                        $semestres=['S5', 'S6'];
                        $modules = array(
                            'S5' => array(
                                'Principes de la programmation',
                                'Initiation Systeme',
                                'Humainites 5'
                            ),
                            'S6' => array(
                                'Developpement et Mathematiques pour l\'ingenieur ',
                                'Programmation reseaux et systeme',
                                'Humainites 6'
                            )
                        );
                        return $this->render('annee/annee.html.twig', [
                            'departement' => $departement,
                            'annee' => $annee,
                            'semestres' => $semestres,
                            'modules' => $modules,
                        ]);

                         break;
                    // case '4A':

                    //     break;
                    // case '5A':

                    //     break;
                    default:
                        return new Response('Invalide annee');

                }
                    
                // break;
            // case 'MRI':

            //     break;
            // case 'ERE':

            //     break;
            default:
                return new Response('Invalid departement');


        }
    }

    // /**
    //  * @Route("/{semestre}", name="semestre")
    //  */
    // public function index(): Response
    // {

    //     return $this->render('semestre/index.html.twig', [
    //         'controller_name' => 'SemestreController',
    //     ]);
    // }
}
