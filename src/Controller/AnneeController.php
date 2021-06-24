<?php

namespace App\Controller;
use App\Entity\Matiere;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                if ($matieres[$i]->getSemestre() != $new) {
                    $new = $matieres[$i]->getSemestre();
                    array_push($semestres, $new);
                }
            }
            // find all modules corresponding to semestre
            for ($i = 0; $i < count($semestres); $i++) {
                $modulesSem = array();
                $module = $repo->findBy(['annee' => $annee, 'departement' => $departement,'semestre' => $semestres[$i]]);
                for ($j = 0; $j < count($module); $j++) {
                    array_push($modulesSem, $module[$j]->getModule());
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
    /**
     * @Route("/main/{departement}/{annee}/{semestre}/{module}", name="matiere", methods={"GET","POST"})
     */
    public function matiere(EntityManagerInterface $em,$annee,$module,$semestre,$departement):Response{
        $matiere=new Matiere;
         $repo=$em->getRepository(Matiere::class);
         $matiere=$repo->findBy(['module'=>$module]);
         return $this->render('main/matiere/liste.html.twig', [
            'matieres'=> $matiere,
            'annee'=>$annee,
            'semestre'=>$semestre,
            'module'=>$module,
            'departement'=>$departement
         ]);
        return new Response('valider');
    }
    /**
     * @Route("/main/{departement}/{annee}/{semestre}/{module}/{id}/delete", name="matiere_delete", methods={"GET","POST"})
     */
    public function delete(Request $request,EntityManagerInterface $em,Matiere $matiere): Response
    {   
        $annee=$matiere->getAnnee();
        $semestre=$matiere->getSemestre();
        $departement=$matiere->getDepartement();
        $module=$matiere->getModule();
        $em->remove($matiere);
        $em->flush();
        return $this->redirect($this->generateUrl('matiere', ['annee'=>$annee,'semestre'=>$semestre,'module'=>$module,'departement'=>$departement] ));
    }
    /**
     * @Route("/main/{departement}/{annee}/{semestre}/{module}/create", name="matiere_create", methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em,$annee,$module,$departement,$semestre):Response
    {
        $form=$this->createFormBuilder()
            ->add('name',TextType::class)
            ->add('annee',TextType::class,['data'=>$annee])
            ->add('departement',TextType::class,['data'=>$departement])
            ->add('semestre',TextType::class,['data'=>$semestre])
            ->add('module',TextType::class,['data'=>$module])
            ->add('introduction',TextareaType::class,['required'=>false])
            ->add('contenu',TextareaType::class,['required'=>false])
            ->add('prerequis',TextareaType::class,['required'=>false])
            ->add('submit',SubmitType::class, ['label'=>"ajouter matiere"])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $matiere=new Matiere;
            $matiere->setName($data["name"]);
            $matiere->setAnnee($data["annee"]);
            $matiere->setDepartement($data["departement"]);
            $matiere->setSemestre($data["semestre"]);
            $matiere->setModule($data["module"]);
            $matiere->setIntroduction($data["introduction"]);
            $matiere->setContenu($data["contenu"]);
            $matiere->setPrerequis($data["prerequis"]);
            $em->persist($matiere);
            $em->flush();
            return $this->redirect($this->generateUrl('matiere', ['annee'=>$data["annee"],'semestre'=>$data["semestre"],'module'=>$data["module"],'departement'=>$data["departement"]]));
       }
       return $this->render('main/matiere/create.html.twig',
        ['form'=>$form->createView(),
            ]);
    }

    /**
     * @Route("/main/{departement}/{annee}/{semestre}/{module}/{id}/edit", name="matiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,EntityManagerInterface $em,$annee,$module,$semestre,$departement,$id,Matiere $matiere):Response{
        $form = $this->createFormBuilder()
        ->add('name',TextType::class,['data'=>$matiere->getName()])
            ->add('annee',TextType::class,['data'=>$matiere->getAnnee()])
            ->add('departement',TextType::class,['data'=>$matiere->getDepartement()])
            ->add('semestre',TextType::class,['data'=>$matiere->getSemestre()])
            ->add('module',TextType::class,['data'=>$matiere->getModule()])
            ->add('introduction',TextareaType::class,['data'=>$matiere->getIntroduction(),'required'=>false])
            ->add('contenu',TextareaType::class,['data'=>$matiere->getContenu(),'required'=>false])
            ->add('prerequis',TextareaType::class,['data'=>$matiere->getPrerequis(),'required'=>false])
            ->add('submit',SubmitType::class, ['label'=>"modifier matiere"])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $matiere->setName($data["name"]);
            $matiere->setAnnee($data["annee"]);
            $matiere->setDepartement($data["departement"]);
            $matiere->setSemestre($data["semestre"]);
            $matiere->setModule($data["module"]);
            $matiere->setIntroduction($data["introduction"]);
            $matiere->setContenu($data["contenu"]);
            $matiere->setPrerequis($data["prerequis"]);
            $em->persist($matiere);
            $em->flush();
            return $this->redirect($this->generateUrl('matiere', ['annee'=>$data["annee"],'semestre'=>$data["semestre"],'module'=>$data["module"],'departement'=>$data["departement"]]));
        }

        return $this->render('main/matiere/edit.html.twig',
            ['form'=>$form->createView(),
                'matiere'=>$matiere,
                'annee'=>$annee,
                'semestre'=>$semestre,
                'module'=>$module,
                'departement'=>$departement
                ]);
    }
    /**
     * @Route("/main/{departement}/{annee}/{semestre}/{module}/{id}/show", name="matiere_show", methods={"GET","POST"})
     */
    public function show(Request $request,EntityManagerInterface $em,$annee,$module,$semestre,$departement,$id,Matiere $matiere):Response{
        return $this->render('main/matiere/show.html.twig',[
           'matiere'=>$matiere,
           'annee'=>$annee,
            'semestre'=>$semestre,
            'module'=>$module,
            'departement'=>$departement
        ]);
    }
}
