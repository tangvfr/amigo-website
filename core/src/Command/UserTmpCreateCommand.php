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
    name: 'user:tmp:create',
    description: 'Permet d\'ajouter un utilisateur root temporaire',
)]
class UserTmpCreateCommand extends Command
{
    public const TMP_USER_NAME = 'TempUser';
    /*public const TMP_LAST_USER_NAME = 'ElTemp';
    public const TMP_END_EMAIL = '@temp-user.net';*/
    public const TMP_ROLES = ['ROLE_ROOT'];
    public const LENGTH_PASS = 32;

    public function __construct(
        public UserPasswordHasherInterface $passwordHasher,
        public EntityManagerInterface $entityManager,
    ){
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        //$fakeStu = new Student();
        $num = TmpRootIdGenerator::generateTmpRootId();

        //init student
        /*$fakeStu->setStudentNumber($num)
            ->setName(self::TMP_USER_NAME)
            ->setLastName(self::TMP_LAST_USER_NAME)
            ->setEmail($num.self::TMP_END_EMAIL)
            ->setLevel(StudentType::OTHER);
        $this->entityManager->persist($fakeStu);*/

        //init user
        $tmpUser = new User();
        $tmpUser->setLogin($num);
        $tmpUser->setRoles(self::TMP_ROLES);
        $plaintextPassword = self::regeneratePassword($tmpUser, $this->passwordHasher);

        //save et persist du user
        $this->entityManager->persist($tmpUser);
        $this->entityManager->flush();

        //affichage
        $comment = [];
        $comment[] = 'Utilisateur temporaire crée:';
        $comment[] = 'id utilisateur: '.$tmpUser->getId();
        $comment[] = 'roles: '.implode(',', $tmpUser->getRoles());
        $comment[] = 'login: '.$tmpUser->getLogin();
        $comment[] = 'mot de passe: '.$plaintextPassword;

        $io->info(join("\n", $comment));
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
