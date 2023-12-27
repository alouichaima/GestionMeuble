<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;




    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Produit::class)]
    private Collection $categorie_produit;

    public function __construct()
    {
        $this->categorie_produit = new ArrayCollection();
    }

    public function __toString(){
        return $this->type;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }


    /**
     * @return Collection<int, Produit>
     */
    public function getCategorieProduit(): Collection
    {
        return $this->categorie_produit;
    }

    public function addCategorieProduit(Produit $categorieProduit): static
    {
        if (!$this->categorie_produit->contains($categorieProduit)) {
            $this->categorie_produit->add($categorieProduit);
            $categorieProduit->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorieProduit(Produit $categorieProduit): static
    {
        if ($this->categorie_produit->removeElement($categorieProduit)) {
            // set the owning side to null (unless already changed)
            if ($categorieProduit->getCategorie() === $this) {
                $categorieProduit->setCategorie(null);
            }
        }

        return $this;
    }


}
