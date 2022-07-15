<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateursController extends AbstractController
{
    /**
     * @Route("/utilisateurs/add", name="add_utilisateur_page")
     */
    public function addChantierPage(Request $request): Response
    {
        $utilisateur = new Utilisateurs();
        $form = $this->createForm(UtilisateurType::class,$utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('utilisateursPage');
        }
        return $this->render('utilisateurs/add_utilisateur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/utilisateurs/update/{id}", name="update_utilisateur")
     */
    public function updateChantier(Request $request, Utilisateurs $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class,$utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->redirectToRoute('utilisateursPage');
        }
    }

    /**
     * @Route("/utilisateurs/get/{id}", name="get_utilisateur")
     */
    public function getChantier(Request $request, Utilisateurs $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class,$utilisateur);
        return $this->render('utilisateurs/get_utilisateur.html.twig', [
            'form' => $form->createView(),
            'id' => $utilisateur->getId()
        ]);
    }

    /**
     * @Route("/utilisateurs/delete/{id}", name="delete_utilisateur")
     */
    public function deleteChantier(Utilisateurs $utilisateur): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        return $this->redirectToRoute('utilisateursPage');
    }
}
