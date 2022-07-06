<?php

namespace Hyperion\Doctrine;

use Hyperion\Doctrine\DoctrineEvents\TablePrefixSubscriber;
use Hyperion\Doctrine\Service\DoctrineService;
use WP_CLI;

class Plugin
{
    public const ADD_ENTITIES_FILTER = 'doctrine_entities';
    public const ADD_EVENT_FILTER = 'doctrine_events';

    public static function onActivation()
    {
        global $wpdb;
        $dbPrefix = getenv('DB_PREFIX') === false ? 'wp_' : getenv('DB_PREFIX');

        $wpdb->query("ALTER TABLE ".$dbPrefix."posts modify post_parent bigint unsigned null");
        $wpdb->query("ALTER TABLE ".$dbPrefix."comments modify user_id bigint unsigned null");
        $wpdb->query("CREATE TRIGGER triggerInsertZeroToNull BEFORE INSERT ON ".$dbPrefix."posts FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerUpdateZeroToNull BEFORE UPDATE ON ".$dbPrefix."posts FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerInsertZeroToNullForComments BEFORE INSERT ON ".$dbPrefix."comments FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerUpdateZeroToNullForComments BEFORE UPDATE ON ".$dbPrefix."comments FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("DELETE FROM $wpdb->postmeta where post_parent not in (select ID from $wpdb->post)");
        $wpdb->query("DELETE FROM $wpdb->termmeta where term_id not in (select term_id from $wpdb->terms)");
        $wpdb->query("DELETE FROM $wpdb->commentmeta where comment_id not in (select comment_ID from $wpdb->comments)");
        $wpdb->query("DELETE FROM $wpdb->term_relationships where term_taxonomy_id not in (select term_taxonomy_id from $wpdb->term_taxonomy)");
        $wpdb->query("DELETE FROM $wpdb->term_taxonomy where term_taxonomy_id not in (select term_taxonomy_id from $wpdb->term_taxonomy)");
        $wpdb->query("DELETE FROM $wpdb->usermeta where user_id not in (select ID from $wpdb->users)");
        $wpdb->query("UPDATE ".$dbPrefix."posts SET post_parent = null WHERE post_parent=0 OR post_parent not in (select ID from ".$dbPrefix."posts);");
        $wpdb->query("UPDATE ".$dbPrefix."comments SET user_id = null WHERE user_id=0;");
    }

    public static function onDeactivation()
    {
        global $wpdb;
        $dbPrefix = getenv('DB_PREFIX') === false ? 'wp_' : getenv('DB_PREFIX');

        $wpdb->query("UPDATE ".$dbPrefix."posts SET post_parent = 0 WHERE post_parent IS NULL");
        $wpdb->query("UPDATE ".$dbPrefix."comments SET user_id = 0 WHERE user_id IS NULL");
        $wpdb->query("DROP TRIGGER triggerInsertZeroToNull");
        $wpdb->query("DROP TRIGGER triggerUpdateZeroToNull");
        $wpdb->query("DROP TRIGGER triggerInsertZeroToNullForComments");
        $wpdb->query("DROP TRIGGER triggerUpdateZeroToNullForComments");
        $wpdb->query("ALTER TABLE ".$dbPrefix."posts modify post_parent bigint unsigned default 0 not null");
    }

    public static function init()
    {
        add_filter(self::ADD_ENTITIES_FILTER, 'Hyperion\Doctrine\Plugin::addWordPressEntityPath');
        add_filter(self::ADD_EVENT_FILTER, 'Hyperion\Doctrine\Plugin::addWordpressDoctrineEvent');
        DoctrineService::addEntities(apply_filters(self::ADD_ENTITIES_FILTER, array()));
        DoctrineService::initializeORM();
    }

    public static function addCLICommands()
    {
        WP_CLI::add_command('doctrine_cli', ['Hyperion\Doctrine\Command\DoctrineCommands','runCommand']);
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