<?php

namespace App\Service;

use App\Model\PokeApi\PokemonListResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PokeApiService
{
    private const BASE_URL = 'https://pokeapi.co/api/v2/';

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer
    ) {
    }

    public function getPokemonList(int $limit = 151, int $offset = 0): ?PokemonListResponse
    {
        try {
            $response = $this->client->request('GET', self::BASE_URL . 'pokemon', [
                'query' => [
                    'limit' => $limit,
                    'offset' => $offset,
                ],
            ]);

            $content = $response->getContent();

            return $this->serializer->deserialize(
                $content, 
                PokemonListResponse::class, 
                'json',
                [
                    'allow_extra_attributes' => true,
                    'type' => PokemonListResponse::class
                ]
            );
        } catch (\Exception $e) {

            return null;
        }
    }

     public function getPokemonDetail(string $nameOrId): array
     {
         try {
             $response = $this->client->request('GET', self::BASE_URL . 'pokemon/' . $nameOrId);
             return $response->toArray();
         } catch (\Exception $e) {
             return [];
         }
     }
}
