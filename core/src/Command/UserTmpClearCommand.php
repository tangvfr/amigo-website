<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'user:tmp:clear',
    description: 'Permet de supprimer tous les utilisateurs root temporaire.',
)]
class UserTmpClearCommand extends Command
{

    public function __construct(
        public UserRepository $userRepository,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nb = $this->userRepository->deleteTmpUsers();
        $io->success('Vous venez de supprimer '.$nb.' utilisateur(s) temporaire(s) !');

        return Command::SUCCESS;
    }

}
