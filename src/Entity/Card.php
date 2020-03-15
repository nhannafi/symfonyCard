<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attack;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $life;
/**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="name")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

         /** @ORM\ManyToMany(targetEntity="App\Entity\SpecialCapacity", mappedBy="cards")
     * @Assert\Count(min="0", max="2")
     */
    private $SpecialCapacity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAttack(): ?string
    {
        return $this->attack;
    }

    public function setAttack(string $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getLife(): ?string
    {
        return $this->life;
    }

    public function setLife(string $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    /**
     * @return Collection|SpecialCapacity[]
     */
    public function getSpecialCapacities(): Collection
    {
        return $this->specialCapacities;
    }
    public function addSpecialCapacity(SpecialCapacity $specialCapacity): self
    {
        if (!$this->specialCapacities->contains($specialCapacity)) {
            $this->specialCapacities[] = $specialCapacity;
            $specialCapacity->addCard($this);
        }
        return $this;
    }
    public function removeSpecialCapacity(SpecialCapacity $specialCapacity): self
    {
        if ($this->specialCapacities->contains($specialCapacity)) {
            $this->specialCapacities->removeElement($specialCapacity);
            $specialCapacity->removeCard($this);
        }
        return $this;
    }
   
}
