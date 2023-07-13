<?php

namespace App\Entity;

use App\Repository\TeacherMetasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherMetasRepository::class)]
class TeacherMetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   // #[ORM\Column(length: 255)]
  //  private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description_preview = null;

    #[ORM\Column(length: 255)]
    private ?string $description_complete = null;

    #[ORM\OneToOne(mappedBy: 'description', cascade: ['persist', 'remove'])]
    private ?Teachers $teachers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

   // public function getName(): ?string
   // {
    //    return $this->name;
   // }

  //  public function setName(string $name): self
   // {
   //     $this->name = $name;

    //    return $this;
  //  }

    public function getDescriptionPreview(): ?string
    {
        return $this->description_preview;
    }

    public function setDescriptionPreview(string $description_preview): self
    {
        $this->description_preview = $description_preview;

        return $this;
    }

    public function getDescriptionComplete(): ?string
    {
        return $this->description_complete;
    }

    public function setDescriptionComplete(string $description_complete): self
    {
        $this->description_complete = $description_complete;

        return $this;
    }

    public function getTeachers(): ?Teachers
    {
        return $this->teachers;
    }

    public function setTeachers(Teachers $teachers): self
    {
        // set the owning side of the relation if necessary
        if ($teachers->getDescription() !== $this) {
            $teachers->setDescription($this);
        }

        $this->teachers = $teachers;

        return $this;
    }

    public function __tostring(){

        return $this->getId();
    }
}
