<?php

namespace App\Controller;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Utilisateurs;
use App\Repository\ChantiersRepository;
use App\Repository\PointagesRepository;
use App\Repository\UtilisateursRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PointagesController extends AbstractController
{
    /**
     * @Route("/pointages/add", name="add_pointage")
     */
    public function addPointage(Request $request,UtilisateursRepository $utilisateursRepo,ChantiersRepository $chantiersRepo): Response
    {
        $data = $request->request->all();
        $pointage = new Pointages();
        $personne = $utilisateursRepo->find($data['idOuvrier']);
        $this->checkIfUtilisateurAllowedToPointe($personne,new DateTime($data['datePointage']));
        $pointage->setUtilisateur($personne);
        $chantier = $chantiersRepo->find($data['idChantier']);
        $pointage->setChantier($chantier);
        $pointage->setDuree($data['heureDebut'],$data['heureFin']);
        $this->checkLimitHoursInWeekPerUser($personne,new DateTime($data['datePointage']),$pointage);
        $pointage->setDate(new DateTime($data['datePointage']));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($pointage);
        $entityManager->flush();
        return $this->json("test",200);
    }
    private function checkIfUtilisateurAllowedToPointe(Utilisateurs $utilisateur,DateTimeInterface $date){
        $pointagesPerUtilisateur = $this->getDoctrine()->getRepository(Pointages::class)->findUtilisateurByWeek($utilisateur,$date);
        $p = '';
    }
    private function checkLimitHoursInWeekPerUser(Utilisateurs $utilisateur,DateTimeInterface $date, Pointages $pointage){
        $pointagesPerUtilisateur = $this->getDoctrine()->getRepository(Pointages::class)->findUtilisateurByWeek($utilisateur,$date);
        $minutes = 0;
        $hours = 0;
        foreach($pointagesPerUtilisateur as $pointage){
            $minutes += $pointage->getDuree()->i;
            if($minutes>=60){
                $minutes -= 60;
                $hours++;
            }
            $hours += $pointage->getDuree()->h;
        }
        $minutes += $pointage->getDuree()->i;
        if($minutes>=60){
            $minutes -= 60;
            $hours++;
        }
        $hours += $pointage->getDuree()->h;
        if($hours>35){
            return false;
        }
        return true;
    }
}
