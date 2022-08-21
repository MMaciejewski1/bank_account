<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\Column(length: 6)]
    private ?string $acid = null;

    #[ORM\Column(length: 6)]
    private ?string $custid = null;

    #[ORM\Column(nullable: true)]
    private ?int $opening_balance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(length: 30)]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $mail = null;


    public function getAcid(): ?string
    {
        return $this->acid;
    }

    public function setAcid(string $acid): self
    {
        $this->acid = $acid;

        return $this;
    }

    public function getCustid(): ?string
    {
        return $this->custid;
    }

    public function setCustid(string $custid): self
    {
        $this->custid = $custid;

        return $this;
    }

    public function getOpeningBalance(): ?int
    {
        return $this->opening_balance;
    }

    public function setOpeningBalance(?int $opening_balance): self
    {
        $this->opening_balance = $opening_balance;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }
}
