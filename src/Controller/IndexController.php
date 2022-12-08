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

class IndexController extends AbstractController
{
/**
 *@Route("/cours_titre/",name="cours_list")
 */
 public function home(Request $request)
 {
 $propertySearch = new PropertySearch();
 $form = $this->createForm(PropertySearchType::class,$propertySearch);
 $form->handleRequest($request);
 //initialement le tableau des articles est vide,
 //c.a.d on affiche les articles que lorsque l'utilisateur
 //clique sur le bouton rechercher
 $cours= [];

 if($form->isSubmitted() && $form->isValid()) {
 //on récupère le nom d'article tapé dans le formulaire
 $titre = $propertySearch->getTitre();
 if ($titre!="")
 //si on a fourni un nom d'article on affiche tous 
 $cours= $this->getDoctrine()->getRepository(Cours::class)->findBy(['titre' => $titre] );
 else
 //si si aucun nom n'est fourni on affiche tous les articles
 $cours= $this->getDoctrine()->getRepository(Article::class)->findAll();
 }
 return $this->render('cours/coursParTitre.html.twig',[ 'form' =>$form->createView(), 'cours' => $cours]);
 }
}