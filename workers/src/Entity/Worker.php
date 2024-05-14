<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkerRepository::class)]
class Worker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(length: 25)]
    private ?string $lastname = null;

    #[ORM\Column(length: 25)]
    private ?string $job = null;

    #[ORM\Column]
    private ?int $Number = null;

    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(int $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    
}
