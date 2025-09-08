<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ScheduleRepository;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $startHour = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isBooked = false;

    #[ORM\ManyToOne(targetEntity: Service::class, inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;

    #[ORM\OneToMany(mappedBy: 'schedule', targetEntity: Order::class, orphanRemoval: true)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getStartHour(): ?\DateTimeImmutable { return $this->startHour; }
    public function setStartHour(\DateTimeImmutable $startHour): self { $this->startHour = $startHour; return $this; }

    public function getIsBooked(): bool { return $this->isBooked; }
    public function setIsBooked(bool $isBooked): self { $this->isBooked = $isBooked; return $this; }

    public function getService(): ?Service { return $this->service; }
    public function setService(?Service $service): self { $this->service = $service; return $this; }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection { return $this->orders; }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setSchedule($this);
        }
        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getSchedule() === $this) {
                $order->setSchedule(null);
            }
        }
        return $this;
    }
}
