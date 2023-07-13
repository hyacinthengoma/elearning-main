<?php

namespace App\Entity;

use App\Repository\CourseMetasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseMetasRepository::class)]
class CourseMetas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //#[ORM\Column]
    //private ?int $course_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_courte = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_complete = null;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'course_meta_id')]
    private Collection $courses;

     #[ORM\OneToOne(mappedBy: 'description', cascade: ['persist', 'remove'])]
     private ?Course $course = null;

   // #[ORM\OneToOne(mappedBy: 'description_preview', cascade: ['persist', 'remove'])]
   // private ?Course $course = null;

   // #[ORM\Column(length: 255)]
   // private ?string $name = null;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getCourseId(): ?int
//    {
//        return $this->course_id;
//    }

//    public function setCourseId(int $course_id): self
//    {
//        $this->course_id = $course_id;
//
//        return $this;
//    }

    public function getMetaKey(): ?string
    {
        return $this->description_courte;
    }

    public function setMetaKey(string $description_courte): self
    {
        $this->description_courte = $description_courte;

        return $this;
    }

    public function getMetaVal(): ?string
    {
        return $this->description_complete;
    }

    public function setMetaVal(string $description_complete): self
    {
        $this->description_complete = $description_complete;

        return $this;
    }

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
            $course->addCourseMetaId($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removeCourseMetaId($this);
        }

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        // unset the owning side of the relation if necessary
        if ($course === null && $this->course !== null) {
            $this->course->setDescription(null);
        }

        // set the owning side of the relation if necessary
        if ($course !== null && $course->getDescription() !== $this) {
            $course->setDescription($this);
        }

        $this->course = $course;

        return $this;
    }
    public function __tostring(){

        return $this->getMetaKey();
    }

   // public function getName(): ?string
   // {
   //     return $this->name;
   // }

   // public function setName(string $name): self
   // {
    //    $this->name = $name;

     //   return $this;
   // }

}
