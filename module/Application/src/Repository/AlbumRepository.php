<?php


namespace Application\Repository;


use Application\CreateObject;
use Application\Entity\Album;
use Application\Entity\Entity;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;
use PDO;
use ReflectionClass;
use function PHPUnit\Framework\isNull;

class AlbumRepository extends AbstractRepository
{

    public function save(Entity $album)
    {
        if (is_null($album->getId())) {
            $this->insert($album);
        } else {
            $this->update($album);
        }
    }

    public function insert(Entity $album): void
    {
        $hydrator = new \Laminas\Hydrator\ClassMethodsHydrator();
        $albumData = $hydrator->extract($album);
        $tableName = $this->getTableName();
        $sql = "INSERT INTO $tableName (name, description, photographer, email, phone, insertDate) VALUES (:name, :description, :photographer, :email, :phone, :insertDate)";
        $placeholders = [
            ':name' => $albumData['name'],
            ':description' => $albumData['description'],
            ':photographer' => $albumData['photographer'],
            ':email' => $albumData['email'],
            ':phone' => $albumData['phone'],
            ':insertDate' => date('Y-m-d H:i:s'),
        ];

        $conn = $this->pdo;

        $sth = $conn->prepare($sql);
        $sth->execute($placeholders);
    }

    public function update(Entity $album): void
    {
        $hydrator = new \Laminas\Hydrator\ClassMethodsHydrator();
        $albumData = $hydrator->extract($album);

        $tableName = $this->getTableName();
        $sql = "UPDATE $tableName SET
                 name = :name,
                 description = :description,
                 photographer = :photographer,
                 email = :email,
                 phone = :phone,
                 updateDate = :updateDate
                 WHERE id = :id";
        $placeholders = [
            ':id' => $albumData['id'],
            ':name' => $albumData['name'],
            ':description' => $albumData['description'],
            ':photographer' => $albumData['photographer'],
            ':email' => $albumData['email'],
            ':phone' => $albumData['phone'],
            ':updateDate' => date('Y-m-d H:i:s'),
        ];

        $conn = $this->pdo;

        $sth = $conn->prepare($sql, $placeholders);
//        dump($sth);
        $sth->execute($placeholders);
    }



    public function getModelClassname(): string
    {
        return Album::class;
    }


    public function getTableName(): string
    {
        return 'album';
    }
}