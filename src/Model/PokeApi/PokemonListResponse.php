<?php

namespace App\Model\PokeApi;

class PokemonListResponse
{
    private int $count;
    private ?string $next;
    private ?string $previous;
    
    /**
     * @var PokemonListResult[]
     */
    private array $results = [];

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function setNext(?string $next): self
    {
        $this->next = $next;
        return $this;
    }

    public function getPrevious(): ?string
    {
        return $this->previous;
    }

    public function setPrevious(?string $previous): self
    {
        $this->previous = $previous;
        return $this;
    }

    /**
     * @return PokemonListResult[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param PokemonListResult[] $results
     */
    public function setResults(array $results): self
    {
        $this->results = $results;
        return $this;
    }
    
     public function addResult(PokemonListResult $result): self
    {
        $this->results[] = $result;
        return $this;
    }
}
