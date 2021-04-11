<?php


namespace Application\Entity;


class Album extends Entity
{
    private ?int $id = null;
    private ?string $name=null;
    private ?string $description=null;
    private ?string $photographer=null;
    private ?string $email=null;
    private ?string $phone=null;

    public function __construct(
//        string $name,
//        string $description,
//        string $photograph,
//        string $email = null,
//        string $phone = null
    )
    {
//        $this->name = $name;
//        $this->description = $description;
//        $this->photograph = $photograph;
//        $this->email = $email;
//        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getPhotographer(): string
    {
        return $this->photographer;
    }

    /**
     * @param string $photographer
     */
    public function setPhotographer(string $photographer): void
    {
        $this->photographer = $photographer;
    }


    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


}