<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Entity\EntityInterface\ReservableEntityInterface;
use App\Repository\GeckoRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;






/**
 * @ORM\Entity(repositoryClass=GeckoRepository::class)
 * @Vich\Uploadable
 * @ApiFilter(
 *      SearchFilter::class,
 *      properties={
 *          "geckType": "exact",
 *      }
 * )
 * @ApiResource(
 *      itemOperations={
 *          "get"
 *      },
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={"get-geckos-for-display"}
 *              }
 *          }
 *      }     
 * )
 */
class Gecko implements DateTimeEntityInterface, ReservableEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("get-geckos-for-display")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("get-geckos-for-display")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("get-geckos-for-display")
     */
    private $sex;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get-geckos-for-display")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("get-geckos-for-display")
     */
    private $geckType;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("get-geckos-for-display")
     */
    private $reserved;

    /**
     * @ORM\ManyToMany(targetEntity="Reservation", mappedBy="gecks")
     */
    private $reservation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("get-geckos-for-display")
     */
    private $filename;

     /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="filename")
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("get-geckos-for-display")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0}, nullable=true)
     */
    private $requestedForReservation;

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

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
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

    public function getGeckType(): ?string
    {
        switch ($this->geckType) {
            case 1:
                return "Lamparci";
            case 2:
                return "Gruboogonowy";
            case 3:
                return "Nowa Kaledonia";
            default: 
                return null;
        }
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        
        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file = null): void
    {
        $this->file = $file;

        if ($file) 
        {
            $this->setCreatedAt(new DateTime());
        }
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): DateTimeEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isRequestedForReservation(): ?bool
    {
        return $this->requestedForReservation;
    }

    public function setRequestedForReservation(bool $requested): self
    {
        $this->requestedForReservation = $requested;

        return $this;
    }

    public function getReservation(): Reservation
    {
        return $this->reservation[0];
    }    

    public function __toString(): string
    {
        return $this->name . " " . $this->sex;
    }
    
}
