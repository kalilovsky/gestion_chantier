<?php

namespace App\Entity;

use App\Repository\PointagesRepository;
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

    public function setDuree(?\DateInterval $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}
