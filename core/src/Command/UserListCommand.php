<?php

namespace App\Command;

use App\Entity\Student;
use App\Entity\StudentType;
use App\Entity\User\AppUser;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use App\Util\TmpRootIdGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsCommand(
    name: 'user:list',
    description: 'Permet de voir la liste des utilisateurs.',
)]
class UserListCommand extends Command
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
        $users = $this->userRepository->findAll();
        $nb = count($users);

        //affichage
        $list = [];
        $list[] = 'Liste des utilisateur(s): ['.$nb.']';
        foreach ($users as $user) {
            if ($user->isTmpRoot()) {
                $puce = '@ ';
                $name = UserTmpCreateCommand::TMP_USER_NAME;
            } else {
                $puce = '- ';
                $name = $user->getUserIdentifier();
            }
            $list[] = "\t".$puce.$user->getLogin().' '.$name;
        }

        $io->info(join("\n", $list));
        $io->success('Voici la liste des utilisateurs ! (@ pour les utilisateurs temporaires)');

        return Command::SUCCESS;
    }

}
