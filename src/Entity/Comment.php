<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\EntityInterface\DateTimeEntityInterface;
use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use DateTime;

/**
 * @ApiResource(
 *      itemOperations={
 *          "get",
 *      },
 *      collectionOperations={
 *          "get",
 *      }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment implements DateTimeEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-blog-post-with-comments"})
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"get-blog-post-with-comments"})
     */
    private $authorName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"get-blog-post-with-comments"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogPost;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthorName()
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

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


    public function getBlogPost() 
    {
        return $this->blogPost;
    }

    public function setBlogPost(BlogPost $blogPost): self
    {
        $this->blogPost = $blogPost;

        return $this;
    }

}
