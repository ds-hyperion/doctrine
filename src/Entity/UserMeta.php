<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserMeta
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="usermeta")
 */
class UserMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint", name="umeta_id")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="metas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", name="meta_key")
     */
    private string $key;

    /**
     * @ORM\Column(type="string", name="meta_value")
     */
    private string $value;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserMeta
     */
    public function setUser(User $user): UserMeta
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return UserMeta
     */
    public function setKey(string $key): UserMeta
    {
        $this->key = $key;
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
     * @return UserMeta
     */
    public function setValue(string $value): UserMeta
    {
        $this->value = $value;
        return $this;
    }

    public function __toString() : string
    {
        return $this->getValue();
    }
}