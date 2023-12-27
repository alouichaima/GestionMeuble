<?php

namespace App\Entity;

use App\Repository\ListeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeCommandeRepository::class)]
class ListeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;




    #[ORM\ManyToOne(inversedBy: 'listeCommandes')]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'listeCommandes')]
    private ?Commande $cmd = null;

    #[ORM\Column]
    private ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCmd(): ?Commande
    {
        return $this->cmd;
    }

    public function setCmd(?Commande $cmd): static
    {
        $this->cmd = $cmd;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

}