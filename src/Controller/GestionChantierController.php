<?php

namespace App\Controller;

use App\Repository\ChantiersRepository;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionChantierController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('gestion_chantier/index.html.twig', [
            'controller_name' => 'GestionChantierController',
        ]);
    }

    /**
     * @Route("/chantiers", name="chantiersPage")
     */
    public function chantiersPage(ChantiersRepository $chantiersRepo): Response
    {
        $chantiers = $chantiersRepo->findAll();
        return $this->render('gestion_chantier/chantiers.html.twig', [
           'chantiers'=>$chantiers
        ]);
    }

    /**
     * @Route("/utilisateurs", name="utilisateursPage")
     */
    public function utilisateursPage(UtilisateursRepository $utilisateursRepo): Response
    {
        $utilisateurs = $utilisateursRepo->findAll();
        return $this->render('gestion_chantier/utilisateurs.html.twig', [
            'personnes' => $utilisateurs
        ]);
    }

    /**
     * @Route("/pointages", name="pointagesPage")
     */
    public function pointagesPage(): Response
    {
        return $this->render('gestion_chantier/pointages.html.twig', [
            
        ]);
    }
}
