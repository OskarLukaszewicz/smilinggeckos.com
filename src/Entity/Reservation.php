<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Repository\ReservationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @ManyToMany(targetEntity="App\Entity\Gecko", inversedBy="reservation")
     * @JoinTable(name="reserved_geckos",
     *      joinColumns={@JoinColumn(name="reservation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="gecko_id", referencedColumnName="id")}
     *      )
     */
    public $gecks;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 20,
     *      max = 1000,
     *      minMessage = "Wiadomość musi zawierać przynajmniej 20 znaków",
     *      maxMessage = "Wiadomość nie może być dłuższa niż 1000 znaków"
     * )
     *)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Expression(
     *      "this.getEmail() === this.getRetypedEmail()",
     *      message="Adresy email nie są identyczne",
     * )
     */
    private $retypedEmail;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private $uniqId;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $alreadySeen;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    private $captchaCode;
    

    public function __construct()
    {
        $this->gecks = new ArrayCollection();
    }

    public function getGecks(): Collection
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
    public function getRetypedEmail(): ?string
    {
        return $this->retypedEmail;
    }

    public function setRetypedEmail(string $retypedEmail): self
    {
        $this->retypedEmail = $retypedEmail;

        return $this;
    }


    public function getcreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): DateTimeEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUniqId(): ?string
    {
        return $this->uniqId;
    }

    public function setUniqId(string $uniqId): self
    {
        $this->uniqId = $uniqId;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function isAlreadySeen(): bool
    {
        return $this->alreadySeen;
    }

    public function setAlreadySeen(bool $seen):self
    {
        $this->alreadySeen = $seen;

        return $this;
    }

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    public function __toString(): string
    {
        return $this->username . " | " . $this->email;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setUniqIdValue(): void
    {
        $this->uniqId = uniqid();
    }

    /**
     * @ORM\PrePersist
     */
    public function setGecksRequested(): void
    {
        foreach ($this->gecks as $gecko)
        {
            $gecko->isRequestedForReservation() ?: $gecko->setRequestedForReservation(true);
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setNotSeen(): void
    {
        $this->alreadySeen = false;
        
    }


}
