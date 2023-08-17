<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    //#[ORM\Column(length: 255)]
    //private ?string $description_preview = null;

    //#[ORM\Column(length: 255)]
    //private ?string $description_complete = null;

    #[ORM\Column]
    private ?float $course_price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;
    //ICI
    #[ORM\ManyToMany(targetEntity: CourseMetas::class, inversedBy: 'courses')]
    private Collection $course_meta_id;

     #[ORM\OneToOne(inversedBy: 'course', cascade: ['persist', 'remove'])]
     private ?CourseMetas $description = null;

     #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'courses')]
     private Collection $categories;

     #[ORM\ManyToOne(inversedBy: 'courses')]
     #[ORM\JoinColumn(nullable: false)]
     private ?Teachers $teacher = null;

     #[ORM\ManyToMany(targetEntity: Level::class, inversedBy: 'courses')]
     private Collection $level_name;

     #[ORM\OneToOne(mappedBy: 'course_id', cascade: ['persist', 'remove'])]
     private ?Appointment $appointment = null;


   // #[ORM\OneToOne(inversedBy: 'course', cascade: ['persist', 'remove'])]
   // private ?CourseMetas $description_preview = null;

   // #[ORM\OneToOne(inversedBy: 'course', cascade: ['persist', 'remove'])]
   // #[ORM\JoinColumn(nullable: false)]
   // private ?CourseMetas $description_complete = null;

    public function __toString(): string {
        return $this->name;
    }

    public function __construct()
    {
        $this->course_meta_id = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->level_name = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    //public function getDescriptionPreview(): ?string
    //{
     //   return $this->description_preview;
   // }

   // public function setDescriptionPreview(string $description_preview): self
   // {
     //   $this->description_preview = $description_preview;

    // return $this;
    //}

    //public function getDescriptionComplete(): ?string
    //{
    //    return $this->description_complete;
    //}

   // public function setDescriptionComplete(string $description_complete): self
   // {
   //     $this->description_complete = $description_complete;

   //     return $this;
   // }

    public function getCoursePrice(): ?float
    {
        return $this->course_price;
    }

    public function setCoursePrice(float $course_price): self
    {
        $this->course_price = $course_price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, CourseMetas>
     */
    public function getCourseMetaId(): Collection
    {
        return $this->course_meta_id;
    }

    public function addCourseMetaId(CourseMetas $courseMetaId): self
    {
        if (!$this->course_meta_id->contains($courseMetaId)) {
            $this->course_meta_id->add($courseMetaId);
        }

        return $this;
    }

    public function removeCourseMetaId(CourseMetas $courseMetaId): self
    {
        $this->course_meta_id->removeElement($courseMetaId);

        return $this;
    }

    public function getDescription(): ?CourseMetas
    {
        return $this->description;
    }

    public function setDescription(?CourseMetas $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescriptionComplete(): ?CourseMetas
    {
        return $this->description_complete;
    }

    public function setDescriptionComplete(CourseMetas $description_complete): self
    {
        $this->description_complete = $description_complete;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getTeacher(): ?Teachers
    {
        return $this->teacher;
    }

    public function setTeacher(?Teachers $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection<int, Level>
     */
    public function getLevelName(): Collection
    {
        return $this->level_name;
    }

    public function addLevelName(Level $levelName): self
    {
        if (!$this->level_name->contains($levelName)) {
            $this->level_name->add($levelName);
        }

        return $this;
    }

    public function removeLevelName(Level $levelName): self
    {
        $this->level_name->removeElement($levelName);

        return $this;
    }

    public function getAppointment(): ?Appointment
    {
        return $this->appointment;
    }

    public function setAppointment(?Appointment $appointment): self
    {
        // unset the owning side of the relation if necessary
        if ($appointment === null && $this->appointment !== null) {
            $this->appointment->setCourseId(null);
        }

        // set the owning side of the relation if necessary
        if ($appointment !== null && $appointment->getCourseId() !== $this) {
            $appointment->setCourseId($this);
        }

        $this->appointment = $appointment;

        return $this;
    }

}

