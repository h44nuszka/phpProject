<?php

namespace App\Entity;

use App\Repository\TagRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"title"})
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     * @Gedmo\Timestampable(on="update")
     */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=64
     *     )
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64"
     * )
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="64"
     * )
     * @Gedmo\Slug(fields={"title"})
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="tags")
     */
    private $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt):void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt):void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title):void
    {
        $this->title = $title;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): void
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addTag($this);
        }
    }

    public function removeEvent(Event $event): void
    {
        if ($this->events->removeElement($event)) {
            $event->removeTag($this);
        }
    }
}
