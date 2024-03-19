<?php

namespace App\Command;

use App\Entity\Student;
use App\Entity\StudentType;
use App\Entity\User\User;
use App\Util\TmpRootIdGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Uuid;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsCommand(
    name: 'user:tmp:clear',
    description: 'Permet de supprimer tous les utilisateurs root temporaire',
)]
class UserTmpClearCommand extends Command
{

    public function __construct(
        public EntityManagerInterface $entityManager,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        //$this->entityManager->

        //$io->info(join("\n", $comment));
        $io->success('Vous venez de crée un utilisateur temporaire !');

        return Command::SUCCESS;
    }

    public static function regeneratePassword(UserInterface $user, UserPasswordHasherInterface $passwordHasher): string
    {
        //generation password
        $plaintextPassword = '';
        for ($i = 0; $i < self::LENGTH_PASS; $i++) {
            $plaintextPassword .= Uuid::randomLetter();
        }

        // hash du password
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        //set de mdp
        $user->setPassword($hashedPassword);

        return $plaintextPassword;
    }

}
