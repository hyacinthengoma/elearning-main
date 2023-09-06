<?php

namespace App\Entity;

use App\Repository\TeachersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: TeachersRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Teachers implements UserInterface, PasswordAuthenticatedUserInterface
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
    #[ORM\JoinColumn(nullable: true)]
    private ?TeacherMetas $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'teacher', targetEntity: Course::class)]
    private Collection $courses;

    #[ORM\OneToMany(mappedBy: 'teachers', targetEntity: Appointment::class)]
    private Collection $slug_id;



    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(nullable: true)]
    private array $roles = [];

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'teachers')]
    private Collection $category;

    #[ORM\ManyToMany(targetEntity: SubCategory::class, inversedBy: 'teachers')]
    private Collection $subcategory;

   // #[ORM\Column(length: 255)]
   // private ?string $name = null;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->slug_id = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->subcategory = new ArrayCollection();
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

    /**
     * @see PasswordAuthenticatedUserInterface
     */
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

  /**
   * @return Collection<int, Appointment>
   */
  public function getSlugId(): Collection
  {
      return $this->slug_id;
  }

  public function addSlugId(Appointment $slugId): self
  {
      if (!$this->slug_id->contains($slugId)) {
          $this->slug_id->add($slugId);
          $slugId->setTeachers($this);
      }

      return $this;
  }

  public function removeSlugId(Appointment $slugId): self
  {
      if ($this->slug_id->removeElement($slugId)) {
          // set the owning side to null (unless already changed)
          if ($slugId->getTeachers() === $this) {
              $slugId->setTeachers(null);
          }
      }

      return $this;
  }




    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_MENTOR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, SubCategory>
     */
    public function getSubcategory(): Collection
    {
        return $this->subcategory;
    }

    public function addSubcategory(SubCategory $subcategory): self
    {
        if (!$this->subcategory->contains($subcategory)) {
            $this->subcategory->add($subcategory);
        }

        return $this;
    }

    public function removeSubcategory(SubCategory $subcategory): self
    {
        $this->subcategory->removeElement($subcategory);

        return $this;
    }



}
