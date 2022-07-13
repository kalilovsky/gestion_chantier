<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateursRepository::class)
 */
class Utilisateurs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="bigint")
     */
    private $matricule;

    /**
     * @ORM\OneToMany(targetEntity=Pointages::class, mappedBy="utilisateur")
     */
    private $pointages;

    public function __construct()
    {
        $this->pointages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection<int, Pointages>
     */
    public function getPointages(): Collection
    {
        return $this->pointages;
    }

    public function addPointage(Pointages $pointage): self
    {
        if (!$this->pointages->contains($pointage)) {
            $this->pointages[] = $pointage;
            $pointage->setUtilisateur($this);
        }

        return $this;
    }

    public function removePointage(Pointages $pointage): self
    {
        if ($this->pointages->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getUtilisateur() === $this) {
                $pointage->setUtilisateur(null);
            }
        }

        return $this;
    }
}
