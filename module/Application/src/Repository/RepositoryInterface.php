<?php


namespace Application\Repository;


use Application\Entity\Album;
use Application\Entity\Entity;

interface RepositoryInterface
{
    public function save(Entity $entity);
    public function insert(Entity $entity): void;
    public function update(Entity $entity): void;
    public function delete(int $entityId);
    public function find(int $id): ?object;
    public function findAll(): array;
    public function findOneBy(array $info): ?object;
    public function getModelClassname(): string;
    public function getTableName(): string;
}