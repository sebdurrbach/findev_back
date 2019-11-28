<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DevSkill", mappedBy="skill")
     */
    private $devSkills;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="skills")
     */
    private $projects;

    public function __construct()
    {
        $this->devSkills = new ArrayCollection();
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

    /**
     * @return Collection|DevSkill[]
     */
    public function getDevSkills(): Collection
    {
        return $this->devSkills;
    }

    public function addDevSkill(DevSkill $devSkill): self
    {
        if (!$this->devSkills->contains($devSkill)) {
            $this->devSkills[] = $devSkill;
            $devSkill->setSkill($this);
        }

        return $this;
    }

    public function removeDevSkill(DevSkill $devSkill): self
    {
        if ($this->devSkills->contains($devSkill)) {
            $this->devSkills->removeElement($devSkill);
            // set the owning side to null (unless already changed)
            if ($devSkill->getSkill() === $this) {
                $devSkill->setSkill(null);
            }
        }

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
            $project->addSkill($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            $project->removeSkill($this);
        }

        return $this;
    }
}
