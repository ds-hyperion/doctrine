<?php

namespace Hyperion\Doctrine;

use Hyperion\Doctrine\DoctrineEvents\TablePrefixSubscriber;
use Hyperion\Doctrine\Entity\Comment;
use Hyperion\Doctrine\Entity\CommentMeta;
use Hyperion\Doctrine\Entity\Link;
use Hyperion\Doctrine\Entity\Option;
use Hyperion\Doctrine\Entity\Post;
use Hyperion\Doctrine\Entity\PostMeta;
use Hyperion\Doctrine\Entity\Term;
use Hyperion\Doctrine\Entity\TermMeta;
use Hyperion\Doctrine\Entity\TermRelationship;
use Hyperion\Doctrine\Entity\TermTaxonomy;
use Hyperion\Doctrine\Entity\User;
use Hyperion\Doctrine\Entity\UserMeta;
use Hyperion\Doctrine\Service\DoctrineService;

class Plugin
{
    public const ADD_ENTITIES_FILTER = 'doctrine_entities';
    public const ADD_EVENT_FILTER = 'doctrine_events';

    public static function init()
    {
        add_filter(self::ADD_ENTITIES_FILTER, 'Plugin::addWordPressEntities');
        add_filter(self::ADD_EVENT_FILTER, 'Plugin::addWordpressDoctrineEvent');
        DoctrineService::addEntities(apply_filters(self::ADD_ENTITIES_FILTER, array()));
        DoctrineService::initializeORM();
    }

    public static function addWordPressEntities(array $entities)
    {
        return array_merge($entities, [
            Comment::class,
            CommentMeta::class,
            Link::class,
            Option::class,
            Post::class,
            PostMeta::class,
            Term::class,
            TermMeta::class,
            TermRelationship::class,
            TermTaxonomy::class,
            User::class,
            UserMeta::class
        ]);
    }

    public static function addWordpressDoctrineEvent(array $doctrineEvents)
    {
        return array_merge($doctrineEvents, [
           TablePrefixSubscriber::class
        ]);
    }
}