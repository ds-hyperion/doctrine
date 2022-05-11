<?php

namespace Hyperion\Doctrine\Command;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Hyperion\Doctrine\Service\DoctrineService;

class DoctrineCommands
{
    public static function runCommand()
    {
        $entityManager = DoctrineService::getEntityManager();

        return ConsoleRunner::createHelperSet($entityManager);
    }
}