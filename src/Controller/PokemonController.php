<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PokemonRepository;

class PokemonController extends AbstractController
{
    #[Route('/', name: 'app_pokemon_index')]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemonRepository->findAll(),
        ]);
    }
}
