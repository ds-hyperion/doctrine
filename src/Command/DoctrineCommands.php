<?php

namespace Hyperion\Doctrine\Command;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Hyperion\Doctrine\Service\DoctrineService;

class DoctrineCommands
{
    public static function runCommand()
    {
        $entityManager = DoctrineService::getEntityManager();
        $helperSet = ConsoleRunner::createHelperSet($entityManager);
        unset($_SERVER['argv'][1]);
        foreach($_SERVER['argv'] as $index => $value) {
            if($value === '--allow-root') {
                unset($_SERVER['argv'][$index]);
            }
        }
        ConsoleRunner::run($helperSet);
    }
}