<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $startingYear;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $graduationYear;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="promotion", orphanRemoval=true)
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

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

    public function getStartingYear(): ?\DateTimeImmutable
    {
        return $this->startingYear;
    }

    public function setStartingYear(\DateTimeImmutable $startingYear): self
    {
        $this->startingYear = $startingYear;

        return $this;
    }

    public function getGraduationYear(): ?\DateTimeImmutable
    {
        return $this->graduationYear;
    }

    public function setGraduationYear(\DateTimeImmutable $graduationYear): self
    {
        $this->graduationYear = $graduationYear;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setPromotion($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getPromotion() === $this) {
                $project->setPromotion(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }
}
