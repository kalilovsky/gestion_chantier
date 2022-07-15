<?php

namespace App\Controller;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Utilisateurs;
use App\Repository\ChantiersRepository;
use App\Repository\PointagesRepository;
use App\Repository\UtilisateursRepository;
use App\Utils\DateUtils;
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
        $chantier = $chantiersRepo->find($data['idChantier']);
        $data['datePointage'] = DateUtils::setStartDate($data['datePointage'],$data['heureDebut']);
        $data['duree'] = DateUtils::createDateIntervall($data['heureDebut'],$data['heureFin']);
        $pointage->setDuree($data['duree']);
        $allowedToPoint = $this->checkIfUtilisateurAllowedToPointe($personne,$chantier,$data['datePointage']);
        $isLimitNotReached = $this->checkLimitHoursInWeekPerUser($personne,$data['datePointage'],$pointage);
        if($allowedToPoint && $isLimitNotReached){
            $pointage->setUtilisateur($personne);
            $pointage->setChantier($chantier);
            $pointage->setDate($data['datePointage']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pointage);
            $entityManager->flush();
            return $this->json(['message'=>'success'],200);
        }elseif(!$allowedToPoint){
            return $this->json(['message'=>'L\'ouvrier a déja pointé ce jour, il ne peut donc pointer !'],200);
        }elseif(!$isLimitNotReached){
            return $this->json(['message'=>'L\'ouvrier a déja dépassé 35 heures pendant cette semaine !'],200);
        }

    }
    private function checkIfUtilisateurAllowedToPointe(Utilisateurs $utilisateur,Chantiers $chantier,DateTimeInterface $date){
        $pointagesPerUtilisateur = $this->getDoctrine()->getRepository(Pointages::class)->findUtilisateurByDate($utilisateur,$chantier,$date);
        if(count($pointagesPerUtilisateur)>0) return false;
        return true;
    }
    private function checkLimitHoursInWeekPerUser(Utilisateurs $utilisateur,DateTimeInterface $date, Pointages $pointage){
        $pointagesPerUtilisateur = $this->getDoctrine()->getRepository(Pointages::class)->findUtilisateurByWeek($utilisateur,$date);
        $minutes = 0;
        $hours = 0;
        DateUtils::sumDateIntervallFromArray($pointagesPerUtilisateur,$minutes,$hours);
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
