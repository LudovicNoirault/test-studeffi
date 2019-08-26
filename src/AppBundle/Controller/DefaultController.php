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
        return $this->render('default/home.html.twig');
    }

    /**
     * @Route("/ajout", name="create")
     */
    public function createAction(Request $request)
    {
        $compteur = new Compteur();

        $form = $this->createForm(CompteurType::class, $compteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compteur = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compteur);
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('default/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/liste", name="list")
     */
    public function listAction(Request $request)
    {
        $listeCompteurs = $this->getDoctrine()->getRepository(Compteur::class)->findAll();

        return $this->render('default/list.html.twig', ['compteurs'=>$listeCompteurs]);
    }

    /**
     * @Route("/liste/{id}", name="read")
     */
    public function readAction(Request $request, $id)
    {
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);
        return $this->render('default/single.html.twig', ['compteur'=>$compteur]);
    }

    /**
     * @Route("/modifier/{id}", name="update")
     */
    public function updateAction(Request $request, $id)
    {
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        $form = $this->createForm(CompteurType::class, $compteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compteur = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compteur);
            $entityManager->flush();

            return $this->redirectToRoute('read', ['id'=>$id]);
        }

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
        $compteur = $this->getDoctrine()->getRepository(Compteur::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($compteur);
        $entityManager->flush();

        return $this->redirectToRoute('list');
    }
}
