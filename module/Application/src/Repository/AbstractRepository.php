<?php


namespace Application\Repository;


use Application\Entity\Entity;
use PDO;
use ReflectionClass;

abstract class AbstractRepository implements RepositoryInterface
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function delete(int $entityId): void {
        $tableName = $this->getTableName();

        $sql = "DELETE FROM $tableName WHERE id = :id";

        $conn = $this->pdo;

        $sth = $conn->prepare($sql);
        $sth->bindValue(':id', $entityId);

        $sth->execute();
    }

    public function find(int $id): ?Entity
    {
        $tableName = $this->getTableName();

        $sql = "SELECT * FROM $tableName WHERE id = :id";


        $conn = $this->pdo;
        $sth = $conn->prepare($sql);

        $sth->execute(['id' => $id]);

        $sth->setFetchMode(PDO::FETCH_ASSOC);

        $album = $sth->fetch();
        if ($album) {
            return $this->createObject($album);
        } else {
            return null;
        }
    }

    public function findAll(): array
    {
        $tableName = $this->getTableName();

        $sql = "SELECT * FROM $tableName";
        $conn = $this->pdo;
        $sth = $conn->prepare($sql);
        $sth->execute();

        $sth->setFetchMode(PDO::FETCH_ASSOC);

        $albums = [];
        while ($album = $sth->fetch()) {
            $albums[] = $this->createObject($album);
        }

        return $albums;
    }


    public function findOneBy(array $data): ?Entity
    {
        $tableName = $this->getTableName();
        $conditionStr = '';

        foreach ($data as $columnName => $value) {
            $conditionStr .= " AND " . $columnName . "=:" . $columnName;
        }
        $conditionStr = mb_substr($conditionStr, 5);

        $sql = "SELECT * FROM $tableName WHERE $conditionStr LIMIT 1";


        $conn = $this->pdo;
        $sth = $conn->prepare($sql);

        $sth->execute($data);

        $sth->setFetchMode(PDO::FETCH_ASSOC);

        $album = $sth->fetch();
        if ($album) {
            return $this->createObject($album);
        } else {
            return null;
        }
    }


    protected function createObject(array $objData): Entity
    {
        $className = $this->getModelClassname();
        $reflection = new ReflectionClass($className);
        $entity = $reflection->newInstanceWithoutConstructor();

        $hydrator = new \Laminas\Hydrator\ReflectionHydrator();

        $entity = $hydrator->hydrate($objData, $entity);
        return $entity;
    }
}