<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Pokedex>
     */
    #[ORM\OneToMany(targetEntity: Pokedex::class, mappedBy: 'pokemon', orphanRemoval: true)]
    private Collection $pokedex;

    public function __construct()
    {
        $this->pokedex = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Pokedex>
     */
    public function getPokedex(): Collection
    {
        return $this->pokedex;
    }

    public function addPokedex(Pokedex $pokedex): static
    {
        if (!$this->pokedex->contains($pokedex)) {
            $this->pokedex->add($pokedex);
            $pokedex->setPokemon($this);
        }

        return $this;
    }

    public function removePokedex(Pokedex $pokedex): static
    {
        if ($this->pokedex->removeElement($pokedex)) {
            // set the owning side to null (unless already changed)
            if ($pokedex->getPokemon() === $this) {
                 // Non-nullable handling
            }
        }

        return $this;
    }
}
