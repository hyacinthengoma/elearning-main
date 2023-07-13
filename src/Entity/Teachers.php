<?php

namespace App\Entity;

use App\Repository\TeachersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeachersRepository::class)]
class Teachers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Training::class)]
    private Collection $trainings;

    #[ORM\OneToOne(inversedBy: 'teachers', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeacherMetas $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Course::class)]
    private Collection $courses;

   // #[ORM\Column(length: 255)]
   // private ?string $name = null;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings->add($training);
            $training->setTeacher($this);
        }

        return $this;
    }

    public function __tostring(){

        return $this->getLastname() . ' ' . $this->getFirstname();
    }

  //  public function name(){

   //     return $this->getLastname() . ' ' . $this->getFirstname();
   // }


    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getTeacher() === $this) {
                $training->setTeacher(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?TeacherMetas
    {
        return $this->description;
    }

    public function setDescription(TeacherMetas $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->getLastname() . ' ' . $this->getFirstname();
    }
   // public function getName(): ?string
   // {
    //    return $this->name;
   // }

   // public function setName(string $name): self
  //  {
  //      $this->name = $name;

  //      return $this;
  // }

  /**
   * @return Collection<int, Course>
   */
  public function getCourses(): Collection
  {
      return $this->courses;
  }

  public function addCourse(Course $course): self
  {
      if (!$this->courses->contains($course)) {
          $this->courses->add($course);
          $course->setTeacher($this);
      }

      return $this;
  }

  public function removeCourse(Course $course): self
  {
      if ($this->courses->removeElement($course)) {
          // set the owning side to null (unless already changed)
          if ($course->getTeacher() === $this) {
              $course->setTeacher(null);
          }
      }

      return $this;
  }






}
