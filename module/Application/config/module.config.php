<?php
declare(strict_types=1);

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */


namespace Application;

use Application\Controller\AlbumController;
use Application\Controller\ImageController;
use Application\Controller\IndexController;
use Application\Repository\AlbumRepository;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Ddl\Index\Index;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\ServiceManager;
use PDO;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

return [
    'router' => [
        'routes' => [
            'add' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/add',
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action' => 'add',
                    ],
                ],
            ],
            'edit' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/edit/:albumId',
                    'constraints' => [
                        'albumId' => '\d+'
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action' => 'edit',
                    ],
                ],
            ],
//            'album' => [
//                'type' => Segment::class,
//                'options' => [
//                    'route' => '[/:action]'
//                ]
//            ],
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'upload' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/images/upload',
                    'defaults' => [
                        'controller' => ImageController::class,
                        'action' => 'upload',
                    ],
                ],
            ],
            'images' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/images[/:action]/:albumId',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'albumId' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller'    => ImageController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => function ($sm) {
                return new IndexController($sm->get('AlbumRepositoryFactory'));
            },
            Controller\AlbumController::class => function ($sm) {
//                dump($sm);
                return new AlbumController($sm->get('AlbumRepositoryFactory'));
            },
            Controller\ImageController::class =>
                Controller\Factory\ImageControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'AlbumRepositoryFactory' => function ($sm) {
                return new AlbumRepository($sm->get('PDOFactory'));
            },
            'AdapterFactory' => function ($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];
                return new Adapter([
                    'driver' => $dbParams['driver'],
                    'hostname' => $dbParams['hostname'],
                    'database' => $dbParams['database'],
                    'username' => $dbParams['username'],
                    'password' => $dbParams['password'],
                ]);
            },
            'PDOFactory' => function ($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];
                $dbDsn = "mysql:host=" . $dbParams['hostname'] . ";dbname=" . $dbParams['database'];
                $pdo = new PDO($dbDsn, $dbParams['username'], $dbParams['password']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            },
            Service\ImageManager::class => InvokableFactory::class,
        ],
    ],
//    'doctrine' => [
//        'connection' => [
//            'orm_default' => [
//                'driverClass' => PDOMySqlDriver::class,
//                'params' => [
//                    'host'     => '127.0.0.1',
//                    'user'     => 'blog',
//                    'password' => '<password>',
//                    'dbname'   => 'blog',
//                ]
//            ],
//        ],
//        'driver' => [
//            __NAMESPACE__ . '_driver' => [
//                'class' => AnnotationDriver::class,
//                'cache' => 'array',
//                'paths' => [__DIR__ . '/../src/Entity']
//            ],
//            'orm_default' => [
//                'drivers' => [
//                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
//                ]
//            ]
//        ]
//    ],
];
