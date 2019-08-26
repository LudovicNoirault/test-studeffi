<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use AppBundle\Form\CompteurType;

use AppBundle\Entity\Compteur;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $request)
    {
        // Affiche la pge d'accueil
        return $this->render('default/home.html.twig');
    }

    /**
     * @Route("/ajout", name="create")
     */
    public function createAction(Request $request)
    {
        // Empèche un utilisateur non connecté d'accéder a cette page.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecter pour accéder a cette page.');

        // Instancie un nouveau compteur
        $compteur = new Compteur();

        // Cree le formulaire relatif aux compteur et lui passe le compteur instancié
        $form = $this->createForm(CompteurType::class, $compteur);
        
        // Vérifie l'état du formulaire
        $form->handleRequest($request);

        // Si celui ci a été soumis et est valide        
        if ($form->isSubmitted() && $form->isValid()) {
            // récupère les données du formulaire
            $compteur = $form->getData();
            
            // Enregistre le compteur en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compteur);
            $entityManager->flush();

            // Redirige vers la liste des compteurs
            return $this->redirectToRoute('list');
        }

        // Si arrive juste la page, render le formulaire
        return $this->render('default/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste", name="list")
     */
    public function listAction(Request $request)
    {
        // Empèche un utilisateur non connecté d'accéder a cette page.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecter pour accéder a cette page.');

        // Récupère tout les compteurs depuis la base de données
        $listeCompteurs = $this->getDoctrine()->getRepository(Compteur::class)->findAll();

        // Envois la liste en parametre de la page liste
        return $this->render('default/list.html.twig', ['compteurs'=>$listeCompteurs]);
    }

    /**
     * @Route("/liste/{id}", name="read")
     */
    public function readAction(Request $request, $id)
    {
        // Empèche un utilisateur non connecté d'accéder a cette page.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecter pour accéder a cette page.');

        // Récupère un compteur spécifique basé sur son id
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        // Envois le compteur en parametre de la page /liste/id
        return $this->render('default/single.html.twig', ['compteur'=>$compteur]);
    }

    /**
     * @Route("/modifier/{id}", name="update")
     */
    public function updateAction(Request $request, $id)
    {
        // Empèche un utilisateur non connecté d'accéder a cette page.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecter pour accéder a cette page.');

        // Récupère un compteur spécifique basé sur son id        
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        // Génère le formulaire de compteur et lui passe le compteur récupéré
        $form = $this->createForm(CompteurType::class, $compteur);

        // Vérifie état du formulaire
        $form->handleRequest($request);

        // Si celui ci a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère la donnée du compteur
            $compteur = $form->getData();
            
            // Enregistre les modifications apportés
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compteur);
            $entityManager->flush();

            // Redirige vers la page du compteur modifié
            return $this->redirectToRoute('read', ['id'=>$id]);
        }

        // Si arrive seulement sur la page render le formulaire avec les informations récupérées sur le compteur
        return $this->render('default/update.html.twig', [
            'form' => $form->createView(),
            'id' => $id
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="delete")
     */
    public function deleteAction(Request $request, $id)
    {
        // Empèche un utilisateur non connecté d'accéder a cette page.
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez être connecter pour accéder a cette page.');

        // trouve le compteur via son ID
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        // Le supprime de la bdd
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($compteur);
        $entityManager->flush();

        // Redirige vers la page /liste
        return $this->redirectToRoute('list');
    }
}
