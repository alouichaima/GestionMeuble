<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;







    #[ORM\OneToMany(mappedBy: 'cmd', targetEntity: ListeCommande::class ,cascade:['persist'])]
    private Collection $listeCommandes;

    #[ORM\ManyToOne(inversedBy: 'user_cmd')]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    public function __construct()
    {
        $this->listeCommandes = new ArrayCollection();
    }




   

    public function getId(): ?int

    {
        return $this->id;
    }







    /**
     * @return Collection<int, ListeCommande>
     */
    public function getListeCommandes(): Collection
    {
        return $this->listeCommandes;
    }

    public function addListeCommande(ListeCommande $listeCommande): self
    {
        if (!$this->listeCommandes->contains($listeCommande)) {
            $this->listeCommandes[] = $listeCommande;
            $listeCommande->setCmd($this);
        }

        return $this;
    }


    public function removeListeCommande(ListeCommande $listeCommande): static
    {
        if ($this->listeCommandes->removeElement($listeCommande)) {
            // set the owning side to null (unless already changed)
            if ($listeCommande->getCmd() === $this) {
                $listeCommande->setCmd(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }





}
