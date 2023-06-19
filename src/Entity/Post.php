<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'post:item']),
        new GetCollection(normalizationContext: ['groups' => 'post:list'])
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['post' => 'exact'])]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['postent:list', 'post:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['postent:list', 'post:item'])]
    private ?string $name = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['postent:list', 'post:item'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 100)]
    #[Groups(['postent:list', 'post:item'])]
    private ?string $annotation = null;

    #[ORM\Column(length: 2000)]
    #[Groups(['postent:list', 'post:item'])]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'post')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comments::class, orphanRemoval: true)]
    private iterable  $comments;
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    #[ORM\Column]
    #[Groups(['postent:list', 'post:item'])]
    #private ?int $views = 0;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAnnotation(): ?string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->text = $views;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

   

    public function removeComments(Comments $comments): self
    {
        if ($this->comments->removeElement($comments)) {
            // set the owning side to null (unless already changed)
            if ($comments->getPost() === $this) {
                $comments->setPost(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
