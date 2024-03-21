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
    name: 'user:delete',
    description: 'Permet de supprimer l\'utilisateur d\'un étudiant.',
)]
class UserDeleteCommand extends Command
{

    public function __construct(
        public EntityManagerInterface $entityManager,
        public UserRepository $userRepository,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('studentNumber', InputArgument::REQUIRED, 'Numéro de l\'étudiant');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $num = $input->getArgument('studentNumber');
        $user = $this->userRepository->findOneBy(['login' => $num]);

        //test si l'étudiant existe
        if ($user === null) {
            $io->error('Aucun utilisateur possède le numéro: '.$num);
            return Command::FAILURE;
        }

        //condition si reset mdp
        $askMsg = 'Souhaitez vous supprimer l\'utilisateur avec le numéro: '
            .$num.' nommée '.$user->getUserIdentifier().' ?'
        ;
        $delete = $io->confirm($askMsg, false);

        if ($delete) {
            //mise à jour donnée sur student si présent
            if (!$user->isTmpRoot()) {//si l'utilisateur est lié à un étudiant
                $student = $user->getStudent();
                $student->setUser(null);
                $user->forceStudent(null);
                $this->entityManager->persist($student);
            }

            //save et persist du user
            $this->userRepository->deleteUserById($user->getId());
            $this->entityManager->flush();

            //affichage
            $comment = [];
            $comment[] = 'Utilisateur supprimer:';
            $comment[] = 'id utilisateur: ' . $user->getId();
            $comment[] = 'roles: ' . implode(',', $user->getRoles());
            $comment[] = 'identifiant: ' . $user->getLogin();

            $io->info(join("\n", $comment));
            $io->success('Vous venez de supprimer un utilisateur !');
        }

        return Command::SUCCESS;
    }

}
