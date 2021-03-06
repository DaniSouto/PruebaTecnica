<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Editorial::class, inversedBy="books")
     */
    private $editorial;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     */
    private $category;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $priority;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEditorial(): ?Editorial
    {
        return $this->editorial;
    }

    public function setEditorial(?Editorial $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->getCategory()->getId();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSingleCategory()
    {
        return $this->category;
    }

    public function setSingleCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * This function adds stock to book stock column, which is where stock is centralized
     * @param Book obj
     * @param Integer value for addition
     * @return Integer total amount of book stock
     */
    public function addStock(Book $book, $units){

        $updatedBookStock = null;

        if(!$book instanceof Book){
            throw new InvalidArgumentException('Obj is not a book');
            return null;
        }

        $currentBookStock = $book->getStock();

        if(is_nan($currentBookStock) || is_nan($units)){
            throw new InvalidArgumentException('Values are not numbers');
            return null;
        }

        $updatedBookStock = intval($units) + intval($currentBookStock);

        if(is_nan($updatedBookStock)){
            return null;
        }else{
            return $updatedBookStock;
        }

    }

}
