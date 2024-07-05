<?php

namespace App\Entity;

use App\Repository\HabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatRepository::class)]
class Habitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descritpion = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaireHabitat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'habitat', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\OneToMany(targetEntity: HabitatImage::class, mappedBy: 'habitat', orphanRemoval: true)]
    private Collection $habitatImages;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->habitatImages = new ArrayCollection();
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

    public function getDescritpion(): ?string
    {
        return $this->descritpion;
    }

    public function setDescritpion(string $descritpion): static
    {
        $this->descritpion = $descritpion;

        return $this;
    }

    public function getCommentaireHabitat(): ?string
    {
        return $this->commentaireHabitat;
    }

    public function setCommentaireHabitat(string $commentaireHabitat): static
    {
        $this->commentaireHabitat = $commentaireHabitat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setHabitat($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getHabitat() === $this) {
                $animal->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HabitatImage>
     */
    public function getHabitatImages(): Collection
    {
        return $this->habitatImages;
    }

    public function addHabitatImage(HabitatImage $habitatImage): static
    {
        if (!$this->habitatImages->contains($habitatImage)) {
            $this->habitatImages->add($habitatImage);
            $habitatImage->setHabitat($this);
        }

        return $this;
    }

    public function removeHabitatImage(HabitatImage $habitatImage): static
    {
        if ($this->habitatImages->removeElement($habitatImage)) {
            // set the owning side to null (unless already changed)
            if ($habitatImage->getHabitat() === $this) {
                $habitatImage->setHabitat(null);
            }
        }

        return $this;
    }
}
