<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateGeckoAction;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Repository\GeckoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;



/**
 * @ORM\Entity(repositoryClass=GeckoRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 *      itemOperations={
 *          "get",
 *          "put"
 *      },
 *      collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "controller"=CreateGeckoAction::class,
 *              "defaults"={"_api_receive"=false},
 *              "denormalization_context"={
 *                  "groups"={"post-by-form"}
 *              },
 *          },
 *          "get",
 *      }
 * )
 */
class Gecko implements DateTimeEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post-by-form")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("post-by-form")
     */
    private $sex;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post-by-form")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post-by-form")
     */
    private $geckType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reserved;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

     /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="filename")
     */
    private $file;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


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

    public function getFilename(): string
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
            $this->setCreatedAt(new DateTime('now'));
        }
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $dateTime): DateTimeEntityInterface
    {
        $this->createdAt = $dateTime;

        return $this;
    }

    // public function getReservation()
    // {
    //     return $this->reservation;
    // }

    // public function setReservation(Reservation $reservation)
    // {
    //     $this->reservation = $reservation;

    //     return $this;
    // }

    public function __toString(): string
    {
        return $this->id . "." . $this->name . " " . $this->sex;
    }
}
