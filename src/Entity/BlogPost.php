<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Repository\BlogPostRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ApiResource(
 *      itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={"get-blog-post-with-comments"}
 *              }
 *          }
 *      },
 *      collectionOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={"get-blog-posts"}
 *              }
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 */
class BlogPost implements DateTimeEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text")
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="blogPost")
     * @ApiSubresource
     * @Groups({"get-blog-post-with-comments"})
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Image")
     * @ORM\JoinTable()
     * @ApiSubresource()
     * @Groups({"get-blog-posts", "get-blog-post-with-comments"})
     */
    private $images;

    public function __construct()
    {
        $comments = new ArrayCollection();
        $this->setComments($comments);

        $this->images = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): DateTimeEntityInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments(Collection $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getImages(): Collection 
    {
        return $this->images;
    }
    public function addImage(Image $image)
    {
        $this->images->add($image);
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function __toString()
    {
        return $this->getId() . " " .$this->getTitle();
    }
}
