<?php

namespace App\Controller;

use App\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Length;

class AnneeController extends AbstractController
{
    /** 
     * @Route("/main/{departement}/{annee}", name="departement_annee")
     */

    public function annee($departement, $annee, EntityManagerInterface $em):Response 
    {
        // $departement = ['STI', 'MRI', 'ERE'];
        // $semestre = ['S5', 'S6', 'S7', 'S8', 'S9', 'S10', ]
        // return new Response(sprintf('This is %s du STI',$annee));

        $repo = $em->getRepository(Matiere::class);
        // $matiere = new Matiere;
        $matieres = $repo->findBy(['annee' => $annee, 'departement' => $departement],['semestre' => 'DESC']);
        $semestres = [];
        $new = '';
        $modules = [];
        if ($matieres){
            // find all semestre of this annee +  departement
            for ($i = 0; $i<count($matieres); $i++){
                if ($matieres[$i].getSemestre() != $new) {
                    $new = $matieres[$i].getSemestre();
                    array_push($semestres, $new);
                }
            }
            // find all modules corresponding to semestre
            for ($i = 0; $i < count($semestres); $i++) {
                $modulesSem = array();
                $module = $repo->findBy(['annee' => $annee, 'departement' => $departement,'semestre' => $semestres[$i]]);
                for ($j = 0; $j < count($module); $j++) {
                    array_push($modulesSem, $module[$j].getModule());
                }
                $modules[$semestres[$i]] = $modulesSem;
            }


            return $this->render('annee/annee.html.twig', [
                                        'departement' => $departement,
                                        'annee' => $annee,
                                        'semestres' => $semestres,
                                        'modules' => $modules,
                                    ]);

        }

        
    //     switch ($departement) {
    //         case 'STI':
    //             switch ($annee) {
    //                 case '3A':
    //                     $semestres=['S5', 'S6'];
    //                     $modules = array(
    //                         'S5' => array(
    //                             'Principes de la programmation',
    //                             'Initiation Systeme',
    //                             'Humainites 5'
    //                         ),
    //                         'S6' => array(
    //                             'Developpement et Mathematiques pour l\'ingenieur ',
    //                             'Programmation reseaux et systeme',
    //                             'Humainites 6'
    //                         )
    //                     );
    //                     return $this->render('annee/annee.html.twig', [
    //                         'departement' => $departement,
    //                         'annee' => $annee,
    //                         'semestres' => $semestres,
    //                         'modules' => $modules,
    //                     ]);

    //                      break;
    //                 // case '4A':

    //                 //     break;
    //                 // case '5A':

    //                 //     break;
    //                 default:
    //                     return new Response('Invalide annee');

    //             }
                    
    //             // break;
    //         // case 'MRI':

    //         //     break;
    //         // case 'ERE':

    //         //     break;
    //         default:
    //             return new Response('Invalid departement');


    //     }
    }
    public function matiere(){

    }

    // /**
    //  * @Route("/main/{semestre}", name="semestre")
    //  */
    // public function index(): Response
    // {

    //     return $this->render('semestre/index.html.twig', [
    //         'controller_name' => 'SemestreController',
    //     ]);
    // }
}
