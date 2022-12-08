<?php

namespace App\Controller;


use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recla')]
class ReclaController extends AbstractController
{
    #[Route('/back', name: 'app_recla_back', methods: ['GET'])]
    public function back(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('back.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_recla_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('recla/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recla_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);
            $this->addFlash('success', 'SEND!');
            return $this->redirectToRoute('app_recla_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recla/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_recla_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('recla/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }



    #[Route('/{id}', name: 'app_recla_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_recla_back', [], Response::HTTP_SEE_OTHER);
    }
}
