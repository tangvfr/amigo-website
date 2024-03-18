<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\Entity\Date\AbstractEditableEntity;
use App\Entity\Date\BeginEndDateEmbeddable;
use App\Repository\MandateRepository;
use App\State\OfficeProvider;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[GetCollection(
    uriTemplate: '/office',
    normalizationContext: ['groups' => 'office'],
    provider: OfficeProvider::class,
)]
#[ORM\Entity(repositoryClass: MandateRepository::class)]
class Mandate extends AbstractEditableEntity
{
    #[ORMId, ORMGeneratedValue, ORMColumn]
    #[Groups(['office'])]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    #[Groups(['office'])]
    private Collection $roles;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['office'])]
    private ?Student $student = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $visible = null;

    #[ORM\Embedded(class: BeginEndDateEmbeddable::class, columnPrefix: false)]
    private BeginEndDateEmbeddable $bgedDate;

    public function __construct()
    {
        $this->bgedDate = new BeginEndDateEmbeddable();
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        $this->roles->removeElement($role);

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getBgedDate(): BeginEndDateEmbeddable
    {
        return $this->bgedDate;
    }

    public function setBgedDate(BeginEndDateEmbeddable $bgedDate): static
    {
        $this->bgedDate = $bgedDate;

        return $this;
    }

    public function getBeginDate(): ?DateTimeInterface
    {
       return $this->bgedDate->getBeginDate();
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->bgedDate->getEndDate();
    }

}
