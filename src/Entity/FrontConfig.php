<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FrontConfigRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=FrontConfigRepository::class)
 * 
 */
class FrontConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $colors = [];

    /**
     * @Assert\NotBlank()
     */
    private $color;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColors(?array $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    public function addColor(): self
    {
        is_array($this->colors) ? array_push($this->colors, $this->color) : $this->setColors($newColors = []);

        $this->setColor(null);
        
        return $this;
    }

    public function removeColor($key): self
    {
        unset($this->colors[$key]);

        return $this;
    }

    public function getColor(): ?string
    {

        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
