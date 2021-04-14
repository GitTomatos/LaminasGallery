<?php


namespace Application\Repository;


use Application\Entity\Entity;
use Application\Entity\Image;
use Laminas\Hydrator\ReflectionHydrator;
use PDO;

class ImageRepository extends AbstractRepository
{

    public function save(Entity $photo)
    {
        if (is_null($photo->getId())) {
            $this->insert($photo);
        } else {
            $this->update($photo);
        }
    }

    public function insert(Entity $photo): void
    {
        $hydrator = new \Laminas\Hydrator\ClassMethodsHydrator();
        $hydrator->setOptions([
            'underscoreSeparatedKeys' => false,
        ]);
        $photoData = $hydrator->extract($photo);
        $tableName = $this->getTableName();
        $sql = "INSERT INTO $tableName (albumId, name, extension, address, date) VALUES (:albumId, :name, :extension, :address, :date)";
        $placeholders = [
            ':albumId' => $photoData['albumId'],
            ':name' => $photoData['name'],
            ':extension' => $photoData['extension'],
            ':address' => $photoData['address'],
            ':date' => date('Y-m-d H:i:s'),
        ];

        $conn = $this->pdo;

        $sth = $conn->prepare($sql);
        $sth->execute($placeholders);
    }

    public function update(Entity $photo): void
    {
        // TODO: Implement update() method.
    }

    public function findLast(int $albumId): ?Image
    {
        $conn = $this->pdo;

        $tableName = $this->getTableName();
        $sql = "SELECT * FROM $tableName WHERE albumId = :albumId ORDER BY date DESC LIMIT 1";

        $sth = $conn->prepare($sql);
        $sth->bindValue(':albumId', $albumId);
        $sth->execute();

        $imageData = $sth->fetch(PDO::FETCH_ASSOC);

        if ($imageData === false) {
            return null;
        }

        $hydrator = new ReflectionHydrator();
        $image =  $hydrator->hydrate($imageData, new Image());
        return $image;
    }

    public function getModelClassname(): string
    {
        // TODO: Implement getModelClassname() method.
    }

    public function getTableName(): string
    {
        return "image";
    }
}