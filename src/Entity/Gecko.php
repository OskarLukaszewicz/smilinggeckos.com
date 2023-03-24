<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GeckosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GeckosRepository::class)
 */
class Gecko
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $geckType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reserved;
    /**
     * @ORM\Column(type="string")
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservation", inversedBy="gecks")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reservation;
    

    public function getId(): ?int
    {
        return $this->id;
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

    public function isSex(): ?bool
    {
        return $this->sex;
    }

    public function setSex(?bool $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGeckType(): ?int
    {
        return $this->geckType;
    }

    public function setGeckType(int $geckType): self
    {
        $this->geckType = $geckType;

        return $this;
    }

    public function isReserved(): ?bool
    {
        return $this->reserved;
    }

    public function setReserved(bool $reserved): self
    {
        $this->reserved = $reserved;

        return $this;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        
        return $this;
    }

    public function getReservation()
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation)
    {
        $this->reservation = $reservation;

        return $this;
    }
}
