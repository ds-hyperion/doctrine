<?php

namespace Hyperion\Doctrine\DoctrineEvents;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Roots\WPConfig\Config;
use Roots\WPConfig\Exceptions\UndefinedConfigKeyException;

class TablePrefixSubscriber implements EventSubscriber
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
        $dbPrefix = getenv('DB_PREFIX') === false ? 'wp_' : getenv('DB_PREFIX');

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