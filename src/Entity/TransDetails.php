<?php

namespace App\Entity;

use App\Repository\TransDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransDetailsRepository::class)]
class TransDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(length: 6)]
    private ?string $tid = null;

    #[ORM\Column(length: 6)]
    private ?string $acnumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dot = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $medium = null;

    #[ORM\Column]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTid(): ?string
    {
        return $this->tid;
    }

    public function setTid(string $tid): self
    {
        $this->tid = $tid;

        return $this;
    }

    public function getAcnumber(): ?string
    {
        return $this->acnumber;
    }

    public function setAcnumber(string $acnumber): self
    {
        $this->acnumber = $acnumber;

        return $this;
    }

    public function getDot(): ?\DateTimeInterface
    {
        return $this->dot;
    }

    public function setDot(?\DateTimeInterface $dot): self
    {
        $this->dot = $dot;

        return $this;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

    public function setMedium(?string $medium): self
    {
        $this->medium = $medium;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
