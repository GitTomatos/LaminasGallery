<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DoctrineAlbum
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="album")
 */
class DoctrineAlbum
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @ORM\Column(name="name")
     */
    private string $name;

    /**
     * @ORM\Column(name="description")
     */
    private string $description;

    /**
     * @ORM\Column(name="photograph")
     */
    private string $photograph;

    /**
     * @ORM\Column(name="email")
     */
    private ?string $email;

    /**
     * @ORM\Column(name="phone")
     */
    private ?string $phone;

    /**
     * @ORM\Column(name="insert_date")
     */
    private string $insertDate;

    /**
     * @ORM\Column(name="update_date")
     */
    private ?string $updateDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPhotograph(): string
    {
        return $this->photograph;
    }

    /**
     * @param string $photograph
     */
    public function setPhotograph(string $photograph): void
    {
        $this->photograph = $photograph;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getInsertDate(): string
    {
        return $this->insertDate;
    }

    /**
     * @param string $insertDate
     */
    public function setInsertDate(string $insertDate): void
    {
        $this->insertDate = $insertDate;
    }

    /**
     * @return string|null
     */
    public function getUpdateDate(): ?string
    {
        return $this->updateDate;
    }

    /**
     * @param string|null $updateDate
     */
    public function setUpdateDate(?string $updateDate): void
    {
        $this->updateDate = $updateDate;
    }



}