<?php

namespace App\Controller;

use App\Repository\ChantiersRepository;
use App\Repository\PointagesRepository;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionChantierController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PointagesRepository $pointagesRepo,UtilisateursRepository $utilisateursRepo,ChantiersRepository $chantiersRepo): Response
    {
        $chantiers = $chantiersRepo->findAll();
        $utilisateurs = $utilisateursRepo->findAll();
        $pointages = $pointagesRepo->findAll();
        return $this->render('gestion_chantier/index.html.twig', [
            "pointages" => $pointages,
            'personnes' => $utilisateurs,
            'chantiers' => $chantiers
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
    public function pointagesPage(PointagesRepository $pointagesRepo,UtilisateursRepository $utilisateursRepo,ChantiersRepository $chantiersRepo): Response
    {
        $chantiers = $chantiersRepo->findAll();
        $utilisateurs = $utilisateursRepo->findAll();
        $pointages = $pointagesRepo->findAll();
        return $this->render('gestion_chantier/pointages.html.twig', [
            "pointages" => $pointages,
            'personnes' => $utilisateurs,
            'chantiers' => $chantiers
        ]);
    }
}
