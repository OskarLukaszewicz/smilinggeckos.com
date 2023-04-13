<?php 

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity()
 * @Vich\Uploadable()
 * @ApiResource(
 *      collectionOperations={
 *          "get",
 *      },
 *      itemOperations={
 *          "get",
 *      }
 * )
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="url")
     */
    private $file;

    /**
     * @ORM\Column(nullable=true)
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function __toString()
    {
        return $this->id . ':' . $this->url;
    }
}