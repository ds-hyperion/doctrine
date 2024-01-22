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

        $wpdb->query("CREATE TRIGGER triggerInsertZeroToNull BEFORE INSERT ON $wpdb->posts FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerUpdateZeroToNull BEFORE UPDATE ON $wpdb->posts FOR EACH ROW IF NEW.post_parent = 0 THEN SET NEW.post_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerInsertZeroToNullForComments BEFORE INSERT ON $wpdb->comments FOR EACH ROW IF NEW.comment_parent = 0 THEN SET NEW.comment_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerUpdateZeroToNullForComments BEFORE UPDATE ON $wpdb->comments FOR EACH ROW IF NEW.comment_parent = 0 THEN SET NEW.comment_parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerInsertZeroToNullForTermTaxonomy BEFORE INSERT ON $wpdb->term_taxonomy FOR EACH ROW IF NEW.parent = 0 THEN SET NEW.parent = null; END IF;");
        $wpdb->query("CREATE TRIGGER triggerUpdateZeroToNullForTermTaxonomy BEFORE UPDATE ON $wpdb->term_taxonomy FOR EACH ROW IF NEW.parent = 0 THEN SET NEW.parent = null; END IF;");

        $wpdb->query("ALTER TABLE $wpdb->posts modify post_parent bigint unsigned null");
        $wpdb->query("ALTER TABLE $wpdb->comments modify user_id bigint unsigned null");
	    $wpdb->query("ALTER TABLE $wpdb->comments modify comment_parent bigint unsigned null");
	    $wpdb->query("UPDATE $wpdb->posts SET post_parent = null WHERE post_parent=0 OR post_parent not in (select ID from (select ID from $wpdb->posts) as subquery);");
        $wpdb->query("UPDATE $wpdb->comments SET user_id = null WHERE user_id=0");
        $wpdb->query("UPDATE $wpdb->term_taxonomy SET parent = null WHERE parent=0;");

        $wpdb->query("DELETE FROM $wpdb->postmeta where post_id not in (select ID from $wpdb->posts)");
        $wpdb->query("DELETE FROM $wpdb->termmeta where term_id not in (select term_id from $wpdb->terms)");
        $wpdb->query("DELETE FROM $wpdb->commentmeta where comment_id not in (select comment_ID from $wpdb->comments)");
        $wpdb->query("DELETE FROM $wpdb->term_relationships where term_taxonomy_id not in (select term_taxonomy_id from $wpdb->term_taxonomy)");
        $wpdb->query("DELETE FROM $wpdb->term_taxonomy where term_id not in (select term_id from $wpdb->terms)");
        $wpdb->query("DELETE FROM $wpdb->term_taxonomy where parent not in (select term_taxonomy_id from ( select term_taxonomy_id from $wpdb->term_taxonomy) as subquery)");
        $wpdb->query("DELETE FROM $wpdb->usermeta where user_id not in (select ID from $wpdb->users)");
    }

    public static function onDeactivation()
    {
        global $wpdb;

        $wpdb->query("UPDATE $wpdb->posts SET post_parent = 0 WHERE post_parent IS NULL");
        $wpdb->query("UPDATE $wpdb->comments SET user_id = 0 WHERE user_id IS NULL");
	    $wpdb->query("UPDATE $wpdb->comments SET comment_parent = 0 WHERE comment_parent IS NULL");
        $wpdb->query("UPDATE $wpdb->term_taxonomy SET parent = 0 WHERE parent IS NULL");
        $wpdb->query("DROP TRIGGER triggerInsertZeroToNull");
        $wpdb->query("DROP TRIGGER triggerUpdateZeroToNull");
        $wpdb->query("DROP TRIGGER triggerInsertZeroToNullForComments");
        $wpdb->query("DROP TRIGGER triggerUpdateZeroToNullForComments");
        $wpdb->query("DROP TRIGGER triggerInsertZeroToNullForTermTaxonomy");
        $wpdb->query("DROP TRIGGER triggerUpdateZeroToNullForTermTaxonomy");
        $wpdb->query("ALTER TABLE $wpdb->posts modify post_parent bigint unsigned default 0 not null");
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
