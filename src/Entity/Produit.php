<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File as HttpFile;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ListeCommande::class)]
    private Collection $listeCommandes;

    #[ORM\ManyToOne(inversedBy: 'categorie_produit')]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'string' ,length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'image')]
    private ?HttpFile $imageFile = null;

    public function getImageFile(): ?HttpFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?HttpFile $imageFile): static
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updated_at = new \DateTimeImmutable();
        }

        return $this;
    }







    public function __construct()
    {
        $this->listeCommandes = new ArrayCollection();
    }







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    /**
     * @return Collection<int, ListeCommande>
     */
    public function getListeCommandes(): Collection
    {
        return $this->listeCommandes;
    }

    public function addListeCommande(ListeCommande $listeCommande): static
    {
        if (!$this->listeCommandes->contains($listeCommande)) {
            $this->listeCommandes->add($listeCommande);
            $listeCommande->setProduit($this);
        }

        return $this;
    }

    public function removeListeCommande(ListeCommande $listeCommande): static
    {
        if ($this->listeCommandes->removeElement($listeCommande)) {
            // set the owning side to null (unless already changed)
            if ($listeCommande->getProduit() === $this) {
                $listeCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

}