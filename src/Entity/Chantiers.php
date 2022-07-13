<?php

namespace App\Entity;

use App\Repository\ChantiersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChantiersRepository::class)
 */
class Chantiers
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
    private $adresse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\OneToMany(targetEntity=Pointages::class, mappedBy="chantier")
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

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
            $pointage->setChantier($this);
        }

        return $this;
    }

    public function removePointage(Pointages $pointage): self
    {
        if ($this->pointages->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getChantier() === $this) {
                $pointage->setChantier(null);
            }
        }

        return $this;
    }
}
