<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="`posts`")
 */
class Post
{
  public function __construct()
  {
    $this->createdAt = new \DateTime();
  }

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
   */
  private $author;

  /**
   * @ORM\Column(type="string")
   * @Assert\Length(min=2, max=40)
   */
  private $title;

  /**
   * @ORM\Column(type="string")
   * @Assert\Length(min=2, max=1000)
   */
  private $content;

  /**
   * @ORM\Column(type="date")
   */
  private $createdAt;


  public function getId(): ?int
  {
    return $this->id;
  }

  public function getAuthor(): ?User
  {
    return $this->author;
  }

  public function setAuthor(User $author)
  {
    $this->author = $author;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title)
  {
    $this->title = $title;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content)
  {
    $this->content = $content;
  }

  public function getCreatedAt(): \DateTime
  {
    return $this->createdAt;
  }
}
