<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $imageData = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: HabitatImage::class, mappedBy: 'image', orphanRemoval: true)]
    private Collection $habitatImages;

    #[ORM\ManyToMany(targetEntity: AnimalImage::class, mappedBy: 'image')]
    private Collection $animalImages;

    #[ORM\ManyToMany(targetEntity: ServiceImage::class, mappedBy: 'image')]
    private Collection $serviceImages;

    public function __construct()
    {
        $this->habitatImages = new ArrayCollection();
        $this->animalImages = new ArrayCollection();
        $this->serviceImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageData()
    {
        return $this->imageData;
    }

    public function setImageData($imageData): static
    {
        $this->imageData = $imageData;

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
            $habitatImage->setImage($this);
        }

        return $this;
    }

    public function removeHabitatImage(HabitatImage $habitatImage): static
    {
        if ($this->habitatImages->removeElement($habitatImage)) {
            // set the owning side to null (unless already changed)
            if ($habitatImage->getImage() === $this) {
                $habitatImage->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalImage>
     */
    public function getAnimalImages(): Collection
    {
        return $this->animalImages;
    }

    public function addAnimalImage(AnimalImage $animalImage): static
    {
        if (!$this->animalImages->contains($animalImage)) {
            $this->animalImages->add($animalImage);
            $animalImage->addImage($this);
        }

        return $this;
    }

    public function removeAnimalImage(AnimalImage $animalImage): static
    {
        if ($this->animalImages->removeElement($animalImage)) {
            $animalImage->removeImage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ServiceImage>
     */
    public function getServiceImages(): Collection
    {
        return $this->serviceImages;
    }

    public function addServiceImage(ServiceImage $serviceImage): static
    {
        if (!$this->serviceImages->contains($serviceImage)) {
            $this->serviceImages->add($serviceImage);
            $serviceImage->addImage($this);
        }

        return $this;
    }

    public function removeServiceImage(ServiceImage $serviceImage): static
    {
        if ($this->serviceImages->removeElement($serviceImage)) {
            $serviceImage->removeImage($this);
        }

        return $this;
    }
}