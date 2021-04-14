<?php


namespace Application\Entity;


class Image extends Entity
{
    private ?int $id = null;
    private ?int $albumId = null;
    private ?string $name = null;
    private ?string $extension = null;
    private ?string $address = null;
    private ?string $date = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    /**
     * @param int|null $albumId
     */
    public function setAlbumId(?int $albumId): void
    {
        $this->albumId = $albumId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getNameWithExtension() {
        return $this->name . "." . $this->extension;
    }


    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @param string|null $extension
     */
    public function setExtension(?string $extension): void
    {
        $this->extension = $extension;
    }


    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }



}