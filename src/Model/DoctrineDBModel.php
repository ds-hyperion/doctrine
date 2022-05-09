<?php

class DoctrineDBModel
{
    public const DEFAULT_TABLE_PREFIX = 'wp_';
    public const DEFAULT_HOST = 'localhost';
    public const DEFAULT_DRIVER = 'pdo_mysql';

    private string $driver;
    private string $user;
    private string $password;
    private string $dbname;
    private string $host;

    public function __construct(string $user,
                                string $password,
                                string $dbname,
                                string $host,
                                string $driver)
    {
        $this->driver = $driver;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->host = $host;
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        extract($vars);

        return compact(array_keys($vars));
    }
}