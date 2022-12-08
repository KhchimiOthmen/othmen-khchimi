<?php


namespace App\Controller;

use App\Entity\Tuteur;
use App\Form\TuteurType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/mail', name: 'mail')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailService $mailService
    ): Response {
        $tuteur = new Tuteur();

        if ($this->getUser()) {
            $tuteur->setFullName($this->getUser()->getFullName())
                ->setEmail($this->getUser()->getEmail());
        }

        $form = $this->createForm(TuteurType::class, $tuteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tuteur = $form->getData();

            $manager->persist($tuteur);
            $manager->flush();

            //Email
            $mailService->sendEmail(
                $tuteur->getEmail(),
                $tuteur->getSubject(),
                'emails/email.html.twig',
                ['tuteur' => $tuteur]);

            $this->addFlash('success','Votre demande a été envoyé avec succès !');

            return $this->redirectToRoute('mail');
        } else {
            $this->addFlash('danger',$form->getErrors() );
        }

        return $this->render('cours/tuteur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}