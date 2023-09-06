<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
/**
 * @ORM\Table(name="category")
 */
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'categories')]
    private Collection $courses;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: SubCategory::class)]
    private Collection $subcategory;

    #[ORM\ManyToMany(targetEntity: Teachers::class, mappedBy: 'category')]
    private Collection $teachers;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->courses = new ArrayCollection();
        $this->subcategory = new ArrayCollection();
        $this->teachers = new ArrayCollection();
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
     * @return Collection<int, self>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);

        }

        return $this;
    }

    public function removeCategory(self $category): self
    {
        $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)



        return $this;
    }

//    public function __tostring(){
//
//        return $this->name;
//    }
    public function __toString(): string{
        return $this->name;
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
            $course->addCategory($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removeCategory($this);
        }

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
            $subcategory->setCategories($this);
        }

        return $this;
    }

    public function removeSubcategory(SubCategory $subcategory): self
    {
        if ($this->subcategory->removeElement($subcategory)) {
            // set the owning side to null (unless already changed)
            if ($subcategory->getCategories() === $this) {
                $subcategory->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Teachers>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teachers $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->addCategory($this);
        }

        return $this;
    }

    public function removeTeacher(Teachers $teacher): self
    {
        if ($this->teachers->removeElement($teacher)) {
            $teacher->removeCategory($this);
        }

        return $this;
    }
}
