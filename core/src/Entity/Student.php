<?php

namespace App\Entity;

use App\Entity\Date\AbstractEditableEntity;
use App\Entity\User\AppUser;
use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[UniqueEntity(fields: ['studentNumber', 'email'])]
class Student extends AbstractEditableEntity
{
    public const START_STU_NUM_PATTERN = 'o';
    public const STU_NUM_PATTERN = '/^'.self::START_STU_NUM_PATTERN.'[0-9]{7,8}$/';

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['office'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['office'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['office'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['office'])]
    private ?string $img = null;

    #[ORM\Column(length: 10, unique: true)]
    #[Assert\NotNull, Assert\Regex(pattern: self::STU_NUM_PATTERN)]
    private ?string $studentNumber = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Unique]
    #[Assert\NotNull, Assert\Email]
    private ?string $email = null;

    #[ORM\Column(enumType: StudentType::class)]
    #[Assert\NotNull]
    #[Groups(['office'])]
    private ?StudentType $level = null;


    #[ORM\OneToOne(targetEntity: AppUser::class, mappedBy: 'student')]
    private ?AppUser $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->name.' '.$this->lastName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getStudentNumber(): ?string
    {
        return $this->studentNumber;
    }

    public function setStudentNumber(string $studentNumber): static
    {
        if (!isset($this->studentNumber) || $this->studentNumber !== $studentNumber) {
            $this->studentNumber = $studentNumber;

            if ($this->hasUser()) {
                $this->user->forceLogin($studentNumber);
            }
        }
        return $this;
    }

    public function getUser(): ?AppUser
    {
        return $this->user;
    }

    public function setUser(?AppUser $user): static
    {
        if ($this->user !== $user) {
            $this->user = $user;

            if ($this->hasUser()) {
                $this->user->forceStudent($this);
            }
        }
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLevel(): ?StudentType
    {
        return $this->level;
    }

    public function setLevel(?StudentType $level): static
    {
        $this->level = $level;

        return $this;
    }
  
    public function hasUser(): bool
    {
        return $this->user !== null;
    }

    public function __toString(): string
    {
        return $this->studentNumber. ' ' .$this->name. ' ' .$this->lastName;
    }

}
