<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EditeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditeurRepository::class)]
#[ApiResource]
class Editeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $publisher = null;

    /**
     * @var Collection<int, Gizmondo>
     */
    #[ORM\OneToMany(targetEntity: Gizmondo::class, mappedBy: 'publisher')]
    private Collection $publisher_name;

    public function __construct()
    {
        $this->publisher_name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection<int, Gizmondo>
     */
    public function getPublisherName(): Collection
    {
        return $this->publisher_name;
    }

    public function addPublisherName(Gizmondo $publisherName): static
    {
        if (!$this->publisher_name->contains($publisherName)) {
            $this->publisher_name->add($publisherName);
            $publisherName->setPublisher($this);
        }

        return $this;
    }

    public function removePublisherName(Gizmondo $publisherName): static
    {
        if ($this->publisher_name->removeElement($publisherName)) {
            // set the owning side to null (unless already changed)
            if ($publisherName->getPublisher() === $this) {
                $publisherName->setPublisher(null);
            }
        }

        return $this;
    }
}
