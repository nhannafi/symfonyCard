<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialCapacityRepository")
 */
class SpecialCapacity
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
     * @ORM\Column(type="integer")
     */
    private $time;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card", inversedBy="SpecialCapacities")
     */
    private $cards;
    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }
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
    public function getTime(): ?int
    {
        return $this->time;
    }
    public function setTime(int $time): self
    {
        $this->time = $time;
        return $this;
    }
    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
        }
        return $this;
    }
    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }
        return $this;
    }
}