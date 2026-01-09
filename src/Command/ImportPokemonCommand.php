<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use App\Service\PokeApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-pokemon',
    description: 'Importe les pokémons depuis PokeAPI',
)]
class ImportPokemonCommand extends Command
{
    public function __construct(
        private PokeApiService $pokeApiService,
        private EntityManagerInterface $entityManager,
        private PokemonRepository $pokemonRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Nombre de Pokémons à importer', 151)
            ->addOption('offset', null, InputOption::VALUE_OPTIONAL, 'Offset de départ', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $limit = (int) $input->getOption('limit');
        $offset = (int) $input->getOption('offset');

        $io->title("Import des Pokémons (Limit: $limit, Offset: $offset)");

        // 1. Récupération des données
        $response = $this->pokeApiService->getPokemonList($limit, $offset);

        if (!$response) {
            $io->error('Impossible de récupérer la liste des Pokémons.');
            return Command::FAILURE;
        }

        $io->progressStart($response->getCount() < $limit ? $response->getCount() : $limit);
        
        $count = 0;
        foreach ($response->getResults() as $result) {
            // Vérifier si le Pokémon existe déjà
            $existing = $this->pokemonRepository->findOneBy(['label' => $result->getName()]);

            if (!$existing) {
                $pokemon = new Pokemon();
                $pokemon->setLabel($result->getName());
                
                // Pour l'instant on ne stocke que le label comme demandé
                // Mais on pourrait stocker l'ID API, l'image, etc.
                
                $this->entityManager->persist($pokemon);
                $count++;
            }
            
            $io->progressAdvance();
        }

        $this->entityManager->flush();
        $io->progressFinish();

        $io->success("$count nouveaux Pokémons importés avec succès !");

        return Command::SUCCESS;
    }
}
