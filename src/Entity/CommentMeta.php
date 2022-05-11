<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CommentMeta
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="commentmeta", indexes={
 *     @Index(name="comment_id", columns={"comment_id"}),
 *     @Index(name="meta_key", columns={"meta_key"})
 * })
 */
class CommentMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint", name="meta_id", options={"unsigned": true})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="metas")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="comment_ID")
     */
    private Comment $comment;

    /**
     * @ORM\Column(type="string", length=255, name="meta_key")
     */
    private string $key;

    /**
     * @ORM\Column(type="text", name="meta_value")
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
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }

    /**
     * @param Comment $comment
     * @return CommentMeta
     */
    public function setComment(Comment $comment): CommentMeta
    {
        $this->comment = $comment;
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
     * @return CommentMeta
     */
    public function setKey(string $key): CommentMeta
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
     * @return CommentMeta
     */
    public function setValue(string $value): CommentMeta
    {
        $this->value = $value;
        return $this;
    }
}