<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostMeta
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="postmeta", indexes={
 *     @ORM\Index(name="meta_key", columns={"meta_key"}),
 *     @ORM\Index(name="post_id", columns={"post_id"})
 * })
 */
class PostMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint", name="meta_id")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="metas")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="ID")
     */
    private Post $post;

    /**
     * @ORM\Column(type="string", length=255, name="meta_key", nullable=true)
     */
    private string $key;

    /**
     * @ORM\Column(type="text", name="meta_value", nullable=true)
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
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return PostMeta
     */
    public function setPost(Post $post): PostMeta
    {
        $this->post = $post;
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
     * @return PostMeta
     */
    public function setKey(string $key): PostMeta
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
     * @return PostMeta
     */
    public function setValue(string $value): PostMeta
    {
        $this->value = $value;
        return $this;
    }

    public function __toString() : string
    {
        return $this->getValue();
    }
}