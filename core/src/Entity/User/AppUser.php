<?php

namespace App\Entity\User;

use App\Command\UserTmpCreateCommand;
use App\Entity\Student;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(fields: ['student'])]
class AppUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    /**
     * @var list<string> The User roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToOne, ORM\JoinColumn(unique: true)]
    private ?Student $student = null;

    #[ORM\Column(length: 10, unique: true)]
    private string $login;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function setStudent(Student $student): static
    {
        $this->student = $student;
        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }
    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * A visual identifier that represents this User.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        $stu = $this->getStudent();
        return $this->isTmpRoot() ? UserTmpCreateCommand::TMP_USER_NAME.' '.$this->login : $stu->getName().' '.$stu->getLastName();
    }

    /**
     * @return list<string>
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the User, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Permet de savoir si l'utilisateur est un User root temporaire
     * @return bool true si l'utilisateur est un User root temporaire
     */
    public function isTmpRoot(): bool
    {
        return $this->student === null;
    }

}
