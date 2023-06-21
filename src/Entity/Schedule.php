<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    public function __toString()
    {
        return $this->day;

        return $this->id;
    }
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 8)]
    private ?string $day = null;

    #[ORM\Column]
    private ?int $opening_hour = null;

    #[ORM\Column]
    private ?int $beginning_break_hour = null;

    #[ORM\Column]
    private ?int $ending_break_hour = null;

    #[ORM\Column]
    private ?int $closing_hour = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningHour(): ?int
    {
        return $this->opening_hour;
    }

    public function setOpeningHour(int $opening_hour): self
    {
        $this->opening_hour = $opening_hour;

        return $this;
    }

    public function getBeginningBreakHour(): ?int
    {
        return $this->beginning_break_hour;
    }

    public function setBeginningBreakHour(int $beginning_break_hour): self
    {
        $this->beginning_break_hour = $beginning_break_hour;

        return $this;
    }

    public function getEndingBreakHour(): ?int
    {
        return $this->ending_break_hour;
    }

    public function setEndingBreakHour(int $ending_break_hour): self
    {
        $this->ending_break_hour = $ending_break_hour;

        return $this;
    }

    public function getClosingHour(): ?int
    {
        return $this->closing_hour;
    }

    public function setClosingHour(int $closing_hour): self
    {
        $this->closing_hour = $closing_hour;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }
}
