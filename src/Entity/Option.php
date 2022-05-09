<?php


namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Option
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="options")
 */
class Option
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="option_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="option_name")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", name="option_value")
     */
    private string $value;

    /**
     * @ORM\Column(type="string", name="autoload")
     */
    private string $autoload;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Option
     */
    public function setId(int $id): Option
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Option
     */
    public function setName(string $name): Option
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Option
     */
    public function setValue(string $value): Option
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoload(): bool
    {
        return $this->autoload === 'yes"';
    }

    /**
     * @param bool $autoload
     * @return Option
     */
    public function setAutoload(bool $autoload): Option
    {
        $this->autoload = $autoload ? 'yes' : 'no';
        return $this;
    }
}