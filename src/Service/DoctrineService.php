<?php

namespace Hyperion\Doctrine\Service;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Exception;
use Hyperion\Doctrine\Model\DoctrineDBModel;
use Hyperion\Doctrine\Plugin;

class DoctrineService
{
    private static EntityManagerInterface $entityManager;
    private static DoctrineDBModel $dbParams;
    private static array $entitiesPath;

    private static function connectDB()
    {
        self::$dbParams = new DoctrineDBModel(
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            getenv('DB_NAME'),
            getenv('DB_HOST') === false ? DoctrineDBModel::DEFAULT_HOST : getenv('DB_HOST'),
            getenv('DB_DRIVER') === false ? DoctrineDBModel::DEFAULT_DRIVER : getenv('DB_DRIVER')
        );
    }

    public static function initializeORM()
    {
        self::connectDB();

        $config = ORMSetup::createAnnotationMetadataConfiguration(
            self::$entitiesPath,
            true
        );

        $entityManager = EntityManager::create(self::$dbParams->toArray(), $config);
        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        Type::addType('uuid_binary_ordered_time', 'Ramsey\Uuid\Doctrine\UuidBinaryOrderedTimeType');
        $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid_binary_ordered_time', 'binary');
        $config->addCustomStringFunction('STR_TO_DATE', 'DoctrineExtensions\Query\Mysql\StrToDate');

        // Add doctrine events
        foreach(apply_filters(Plugin::ADD_EVENT_FILTER, array()) as $subscriber) {
            $entityManager->getEventManager()->addEventSubscriber(new $subscriber());
        }

        self::$entityManager = $entityManager;
    }

    public static function addEntities(array $entitiesPath) : void
    {
        self::$entitiesPath = $entitiesPath;
    }

    public static function getEntityManager() : EntityManagerInterface
    {
        if(!isset(self::$entityManager)) {
            throw new Exception("EntityManager not initialized");
        }

        return self::$entityManager;
    }
}

