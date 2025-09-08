<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: "orders")]  // ← Nom de table corrigé
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 10)]
    private ?string $phone = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $scheduleAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isCompleted = false;

    #[ORM\ManyToOne(targetEntity: Schedule::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Schedule $schedule = null;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    // ================= Getters / Setters =================

    public function getId(): ?int { return $this->id; }

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(string $firstName): self { $this->firstName = $firstName; return $this; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(string $lastName): self { $this->lastName = $lastName; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $phone): self { $this->phone = $phone; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): self { $this->createdAt = $createdAt; return $this; }

    public function getScheduleAt(): ?\DateTimeImmutable { return $this->scheduleAt; }
    public function setScheduleAt(\DateTimeImmutable $scheduleAt): self { $this->scheduleAt = $scheduleAt; return $this; }

    public function isCompleted(): bool { return $this->isCompleted; }
    public function setIsCompleted(bool $isCompleted): self { $this->isCompleted = $isCompleted; return $this; }

    public function getSchedule(): ?Schedule { return $this->schedule; }
    public function setSchedule(?Schedule $schedule): self { $this->schedule = $schedule; return $this; }

    public function getService(): ?Service { return $this->service; }
    public function setService(?Service $service): self { $this->service = $service; return $this; }
}
