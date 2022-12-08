<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Search;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use App\Form\SearchType;
use App\Repository\SearchRepository;
use App\Entity\TitreSearch;
use App\Form\TitreSearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('Cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addCours(ManagerRegistry $doctrine,Request $req): Response {
        $em = $doctrine->getManager();
        $cours = new Cours();
        $form = $this->createForm(CoursType::class,$cours);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($cours);
            $em->flush();
            return $this->redirectToRoute('affiche');
        }

        return $this->renderForm('cours/add.html.twig',['form'=>$form]);
    }
    #[Route('/affiche', name: 'affiche')]
    public function afficheC(): Response
    {
        //recuperer le repository //
        $r=$this->getDoctrine()->getRepository(Cours::class);
        $c=$r->findAll();
        return $this->render('cours/affiche.html.twig', [
            'cours' => $c,]);
       } 
       #[Route('/searchC/{idCours}', name: 'searchC')]

 public function coursParId(Request $request) {
    $cours = new Cours();
    $form = $this->createForm(CoursType::class,$cours);
    $form->handleRequest($request);
    $cours= [];
    if($form->isSubmitted() && $form->isValid()) {
        $cours = $search->getCours();
        
        if ($cours!="")
       $cours= $search->getCours();
        else 
        $cours= $this->getDoctrine()->getRepository(Cours::class)->findAll();
        }
        
        return $this->render('cours/coursParId.html.twig',['form' => $form->createView(),'cours' => $cours]);
        }

        #[Route('/suppC/{idCours}', name: 'suppC')]
        public function SupprimerC($idCours,CoursRepository $repository,
        ManagerRegistry $doctrine): Response
        {
        //récupérer cours à supprimer
        $cours=$repository->find($idCours);
        //Action de suppression via Entity manager
        $em=$doctrine->getManager();
        $em->remove($cours);
        $em->flush();
            return $this->redirectToRoute('affiche');
        }
        
        #[Route('/modifC/{idCours}', name: 'modifC')]
        public function edit(Cours $cours, Request $request): Response
        {
            $form = $this->createForm(CoursType::class, $cours);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
    
                return $this->redirectToRoute('affiche');
            }
            return $this->render("Cours/edit.html.twig", [
                "form" => $form->createView()
            ]);
        }

      
     }