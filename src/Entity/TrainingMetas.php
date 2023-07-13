<?php

namespace App\Entity;

use App\Repository\TrainingMetasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingMetasRepository::class)]
class TrainingMetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

  //  #[ORM\Column(length: 255)]
  //  private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description_preview = null;

    #[ORM\Column(length: 255)]
    private ?string $description_complete = null;

    #[ORM\OneToOne(mappedBy: 'description', cascade: ['persist', 'remove'])]
    private ?Training $training = null;

    public function getId(): ?int
    {
        return $this->id;
    }

  //  public function getName(): ?string
  //  {
  //      return $this->name;
  //  }

  //  public function setName(string $name): self
  //  {
   //     $this->name = $name;

    //    return $this;
   // }

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

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function __tostring(){

        return $this->getId();
    }

    public function setTraining(Training $training): self
    {
        // set the owning side of the relation if necessary
        if ($training->getDescription() !== $this) {
            $training->setDescription($this);
        }

        $this->training = $training;

        return $this;
    }
}
