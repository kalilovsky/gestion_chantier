<?php

namespace App\Entity;

use App\Repository\PointagesRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointagesRepository::class)
 */
class Pointages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateurs::class, inversedBy="pointages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Chantiers::class, inversedBy="pointages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chantier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $duree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getChantier(): ?Chantiers
    {
        return $this->chantier;
    }

    public function setChantier(?Chantiers $chantier): self
    {
        $this->chantier = $chantier;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?\DateInterval
    {
        return $this->duree;
    }
    /**
     * Undocumented function
     *
     * @param String $startTime
     * @param String $endTime
     * @return string|self
     */
    public function setDuree(String $startTime, String $endTime)
    {
        $start = new DateTime($startTime);
        $end = new DateTime($endTime);
        if($end <= $start){
            return 'Heure de fin inférieur à l\'heure de début !';
        }
        $interval = $start->diff($end);
        $this->duree = $interval;
        return $this;
    }
}
