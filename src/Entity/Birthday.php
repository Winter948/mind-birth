<?php

namespace App\Entity;

use App\Repository\BirthdayRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: BirthdayRepository::class)]
class Birthday
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["birthday:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["birthday:read", "birthday:write"])]
    private ?string $title = null;

    #[ORM\Column(type: "date")]
    #[Groups(["birthday:read", "birthday:write"])]
    #[SerializedName("date")] // garde le même nom dans la réponse JSON
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }
}
