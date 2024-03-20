<?php

namespace App\Command;

use App\Entity\Student;
use App\Entity\StudentType;
use App\Entity\User\AppUser;
use App\Repository\StudentRepository;
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
    name: 'user:create',
    description: 'Permet de créer un utilisateur à un étudiant.',
)]
class UserCreateCommand extends Command
{
    public const DEFAULT_ROLES = ['ROLE_USER'];
    public const LENGTH_PASS = 32;

    public function __construct(
        public UserPasswordHasherInterface $passwordHasher,
        public EntityManagerInterface $entityManager,
        public StudentRepository $studentRepository,
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
        $student = $this->studentRepository->findOneBy(['studentNumber' => $num]);

        //test si l'étudiant existe
        if ($student === null) {
            $io->error('Aucun étudiant possède le numéro: '.$num);
            return Command::FAILURE;
        }

        //condition si reset mdp
        if ($student->hasUser()) {
            $askMsg = 'L\'étudiant avec le numéro: '.$num.' nommée '.$student->getDisplayName()
                .' existe déjà. Souhaitez vous réinitialiser son mot de passe ?'
            ;
        } else {
            $askMsg = 'Souhaitez vous créer un utilisateur pour l\'étudiant avec le numéro: '
                .$num.' nommée '.$student->getDisplayName().' ?'
            ;
        }

        $generate = $io->confirm($askMsg, false);

        if ($generate) {
            if (!$student->hasUser()) {
                $validMsg = 'Vous venez de créer un nouvel utilisateur !';
                $validVerb = 'créé';
                //create user
                $user = new AppUser();
                $user->forceStudent($student);
                $user->forceLogin($num);
                $user->setRoles(self::DEFAULT_ROLES);
            } else {
                $validMsg = 'Vous venez de réinitialiser le mot de passe d\'un utilisateur !';
                $validVerb = 'réinitialisé';
                //get user
                $user = $student->getUser();
            }
            //set password
            $plaintextPassword = UserTmpCreateCommand::regeneratePassword($user, $this->passwordHasher);

            //save et persist du user
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            //affichage
            $comment = [];
            $comment[] = 'Utilisateur '.$validVerb.':';
            $comment[] = 'id utilisateur: ' . $user->getId();
            $comment[] = 'étudiant: ' . $user->getUserIdentifier();
            $comment[] = 'roles: ' . implode(',', $user->getRoles());
            $comment[] = 'login: ' . $user->getLogin();
            $comment[] = 'mot de passe: ' . $plaintextPassword;

            $io->info(join("\n", $comment));
            $io->success($validMsg);
        }

        return Command::SUCCESS;
    }

}
