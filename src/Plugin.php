<?php

namespace Hyperion\Doctrine;

use Hyperion\Doctrine\Command\UpdateDatabase;
use Hyperion\Doctrine\DoctrineEvents\TablePrefixSubscriber;
use Hyperion\Doctrine\Service\DoctrineService;
use WP_CLI;

class Plugin
{
    public const ADD_ENTITIES_FILTER = 'doctrine_entities';
    public const ADD_EVENT_FILTER = 'doctrine_events';

    public static function init()
    {
        add_filter(self::ADD_ENTITIES_FILTER, 'Hyperion\Doctrine\Plugin::addWordPressEntityPath');
        add_filter(self::ADD_EVENT_FILTER, 'Hyperion\Doctrine\Plugin::addWordpressDoctrineEvent');
        DoctrineService::addEntities(apply_filters(self::ADD_ENTITIES_FILTER, array()));
        DoctrineService::initializeORM();
    }

    public static function addCLICommands()
    {
        WP_CLI::add_command('doctrine_cli', 'Hyperion\Doctrine\Command\DoctrineCommands::runCommand');
    }

    public static function addWordPressEntityPath(array $entityPaths)
    {
        $entityPaths[] = __DIR__."/Entity";

        return $entityPaths;
    }

    public static function addWordpressDoctrineEvent(array $doctrineEvents)
    {
        return array_merge($doctrineEvents, [
           TablePrefixSubscriber::class
        ]);
    }
}