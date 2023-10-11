<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $NumePrenume = null;

    #[ORM\Column]
    private ?float $Media = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $BirthDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Grupa = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialitate $specialitate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumePrenume(): ?string
    {
        return $this->NumePrenume;
    }

    public function setNumePrenume(string $NumePrenume): static
    {
        $this->NumePrenume = $NumePrenume;

        return $this;
    }

    public function getMedia(): ?float
    {
        return $this->Media;
    }

    public function setMedia(float $Media): static
    {
        $this->Media = $Media;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->BirthDate;
    }

    public function setBirthDate(\DateTimeInterface $BirthDate): static
    {
        $this->BirthDate = $BirthDate;

        return $this;
    }

    public function getGrupa(): ?string
    {
        return $this->Grupa;
    }

    public function setGrupa(string $Grupa): static
    {
        $this->Grupa = $Grupa;

        return $this;
    }

    public function getSpecialitate(): ?Specialitate
    {
        return $this->specialitate;
    }

    public function setSpecialitate(?Specialitate $specialitate): static
    {
        $this->specialitate = $specialitate;

        return $this;
    }
}
