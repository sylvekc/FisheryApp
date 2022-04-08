<?php

namespace App\Entity;

use App\Repository\FisheryReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FisheryReservationsRepository::class)]
class FisheryReservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $position_nr;

    #[ORM\Column(type: 'datetime')]
    private $since_when;

    #[ORM\Column(type: 'datetime')]
    private $until_when;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'fisheryReservations')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $reserved_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionNr(): ?int
    {
        return $this->position_nr;
    }

    public function setPositionNr(int $position_nr): self
    {
        $this->position_nr = $position_nr;

        return $this;
    }

    public function getSinceWhen(): ?\DateTimeInterface
    {
        return $this->since_when;
    }

    public function setSinceWhen(\DateTimeInterface $since_when): self
    {
        $this->since_when = $since_when;

        return $this;
    }

    public function getUntilWhen(): ?\DateTimeInterface
    {
        return $this->until_when;
    }

    public function setUntilWhen(\DateTimeInterface $until_when): self
    {
        $this->until_when = $until_when;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReservedAt(): ?\DateTimeInterface
    {
        return $this->reserved_at;
    }

    public function setReservedAt(\DateTimeInterface $reserved_at): self
    {
        $this->reserved_at = $reserved_at;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
