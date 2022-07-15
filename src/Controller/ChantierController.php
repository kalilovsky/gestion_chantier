<?php

namespace App\Controller;

use App\Entity\Chantiers;
use App\Form\ChantierType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChantierController extends AbstractController
{
    /**
     * @Route("/chantier/add", name="add_chantier_page")
     */
    public function addChantierPage(Request $request): Response
    {
        $chantier = new Chantiers();
        $form = $this->createForm(ChantierType::class,$chantier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chantier = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chantier);
            $entityManager->flush();
            return $this->redirectToRoute('chantiersPage');
        }
        return $this->render('chantier/add_chantier.html.twig', [
            'controller_name' => 'ChantierController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/chantier/update/{id}", name="update_chantier")
     */
    public function updateChantier(Request $request, Chantiers $chantier): Response
    {
        $form = $this->createForm(ChantierType::class,$chantier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chantier = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chantier);
            $entityManager->flush();
            return $this->redirectToRoute('chantiersPage');
        }
    }

    /**
     * @Route("/chantier/get/{id}", name="get_chantier")
     */
    public function getChantier(Request $request, Chantiers $chantier): Response
    {
        $form = $this->createForm(ChantierType::class,$chantier);
        return $this->render('chantier/get_chantier.html.twig', [
            'form' => $form->createView(),
            'id' => $chantier->getId()
        ]);
    }

    /**
     * @Route("/chantier/delete/{id}", name="delete_chantier")
     */
    public function deleteChantier(Chantiers $chantier): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($chantier);
        $entityManager->flush();
        return $this->redirectToRoute('chantiersPage');
    }
}
