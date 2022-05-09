<?php

namespace Hyperion\Doctrine\DoctrineEvents;

use Hyperion\Core\Abstracts\DoctrineEventAbstract;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Roots\WPConfig\Config;
use Roots\WPConfig\Exceptions\UndefinedConfigKeyException;

class TablePrefixSubscriber extends DoctrineEventAbstract
{
    /**
     * Get subscribed events
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(Events::loadClassMetadata);
    }

    /**
     * Load class meta data event
     *
     * @param LoadClassMetadataEventArgs $args
     *
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args) : void
    {
        $classMetadata = $args->getClassMetadata();
        if(class_exists(Config::class)) {
            try {
                $dbPrefix = getenv('DB_PREFIX');
            } catch(UndefinedConfigKeyException $exception) {
                $dbPrefix = 'wp_';
            }
        }
        if (false === strpos($classMetadata->getTableName(), $dbPrefix)) {
            $tableName = $dbPrefix . strtolower($classMetadata->getTableName());
            $classMetadata->setPrimaryTable(['name' => $tableName]);
        }

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] === ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide'] == true) {
                $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];

                // Do not re-apply the prefix when the association is already prefixed
                if (false !== strpos($mappedTableName, $dbPrefix)) {
                    continue;
                }

                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $dbPrefix . $mappedTableName;
            }
        }
    }
}