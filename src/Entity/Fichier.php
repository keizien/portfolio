<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichierRepository::class)]
class Fichier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_original = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_serveur = null;

    #[ORM\Column]
    private ?\DateTime $date_envoi = null;

    #[ORM\Column(length: 5)]
    private ?string $extension = null;

    #[ORM\Column]
    private ?int $taille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOriginal(): ?string
    {
        return $this->nom_original;
    }

    public function setNomOriginal(string $nom_original): static
    {
        $this->nom_original = $nom_original;

        return $this;
    }

    public function getNomServeur(): ?string
    {
        return $this->nom_serveur;
    }

    public function setNomServeur(string $nom_serveur): static
    {
        $this->nom_serveur = $nom_serveur;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTime
    {
        return $this->date_envoi;
    }

    public function setDateEnvoi(\DateTime $date_envoi): static
    {
        $this->date_envoi = $date_envoi;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }
}
