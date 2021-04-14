<?php


namespace Application\Controller\Factory;


use Application\Controller\ImageController;
use Application\Repository\AlbumRepository;
use Application\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ImageControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,
                             $requestedName, array $options = null): ImageController
    {
        $imageManager = $container->get(ImageManager::class);
        $albumRepository = $container->get('AlbumRepositoryFactory');
        $imageRepository = $container->get('ImageRepositoryFactory');

        // Инстанцируем контроллер и внедряем зависимости
        return new ImageController($imageManager, $albumRepository, $imageRepository);
    }
}