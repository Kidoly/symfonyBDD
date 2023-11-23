<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(): Response
    {
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }

    //action pour ajouter une catégorie
    #[Route('/categories/ajouter', name: 'app_categories_ajouter')]
    public function ajouter(Request $request, ManagerRegistry $doctrine): Response
    {
        //création d'un formulaire
        //on crée un objet de la classe Categorie
        $categorie = new Categorie();
        //on crée un formulaire
        $form = $this->createForm(CategorieType::class, $categorie);

        //todo : traiter le formulaire en retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le manager de doctrine
            $manager = $doctrine->getManager();
            //on demande au manager de sauvegarder l'objet
            $manager->persist($categorie);
            //on exécute la requête
            $manager->flush();
            //on redirige vers la liste des catégories
            return $this->redirectToRoute('app_categories');
        }

        return $this->render('categories/ajouter.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }
}
