<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;



/**
 * @ApiResource(
 *      itemOperations={
 *          "get",
 *          "put",
 *      },
 *      collectionOperations={
 *          "get",
 *          "post"
 *      }
 * )
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation implements DateTimeEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToMany(targetEntity="App\Entity\Gecko")
     * @JoinTable(name="reserved_geckos",
     *      joinColumns={@JoinColumn(name="reservation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="gecko_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $gecks;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accepted;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $gecks = new ArrayCollection();
        $this->setGecks($gecks);
    }

    public function getGecks()
    {
        return $this->gecks;
    }

    public function setGecks(Collection $gecks): self
    {
        $this->gecks = $gecks;

        return $this;
    }

    public function addGecko($gecko)
    {
        $this->gecks->add($gecko);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getcreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeInterface $createdAt): DateTimeEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
