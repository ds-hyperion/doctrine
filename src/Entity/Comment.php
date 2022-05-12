<?php

namespace Hyperion\Doctrine\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Hyperion\Core\MetaEntity\Author;

/**
 * Class Comment
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="comments", indexes={
 *     @ORM\Index(name="comment_approved_date_gmt", columns={"comment_approved", "comment_date_gmt"}),
 *     @ORM\Index(name="comment_author_email", columns={"comment_author_email"}),
 *     @ORM\Index(name="comment_date_gmt", columns={"comment_date_gmt"}),
 *     @ORM\Index(name="comment_post_ID", columns={"comment_post_ID"})
 * })
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="comment_ID", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="comment_post_ID", referencedColumnName="ID")
     */
    private Post $post;

    /**
     * @ORM\Column(type="string", name="comment_author")
     */
    private string $author;

    /**
     * @ORM\Column(type="string", length=100, name="comment_author_email", options={"default": ""})
     */
    private string $authorEmail;

    /**
     * @ORM\Column(type="string", name="comment_author_url", length=200, options={"default": ""})
     */
    private string $authorUrl;

    /**
     * @ORM\Column(type="string", name="comment_author_IP", length=100, options={"default": ""})
     */
    private string $authorIp;

    /**
     * @ORM\Column(type="datetime", name="comment_date", options={"default": "0000-00-00 00:00:00"})
     */
    private DateTime $date;

    /**
     * @ORM\Column(type="datetime", name="comment_date_gmt", options={"default": "0000-00-00 00:00:00"})
     */
    private DateTime $dateGMT;

    /**
     * @ORM\Column(type="string", name="comment_content")
     */
    private string $content;

    /**
     * @ORM\Column(type="integer", name="comment_karma", options={"default": 0})
     */
    private int $karma;

    /**
     * @ORM\Column(type="string", length=20, name="comment_approved", options={"default": "1"})
     */
    private bool $approved;

    /**
     * @ORM\Column(type="string", length=255, name="comment_agent", options={"default": ""})
     */
    private string $agent;

    /**
     * @ORM\Column(type="string", length=20, name="comment_type", options={"default":"comment"})
     */
    private string $type;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="childs")
     * @ORM\JoinColumn(name="comment_parent", referencedColumnName="comment_ID")
     */
    private ?Comment $parent = null;

    /**
     * @var Comment[]
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="parent")
     * @ORM\JoinColumn(referencedColumnName="comment_ID")
     */
    private array $childs;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     */
    private User $user;

    /**
     * @var CommentMeta[]
     * @ORM\OneToMany(targetEntity="CommentMeta", mappedBy="comment")
     */
    private array $metas;

    public function __construct()
    {
        $this->childs = [];
        $this->metas = [];
    }

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
     * @return Comment
     */
    public function setPost(Post $post): Comment
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return (new Author())
            ->setEmail($this->authorEmail)
            ->setName($this->author)
            ->setIp($this->authorIp)
            ->setUrl($this->authorUrl);
    }

    /**
     * @param Author $author
     * @return Comment
     */
    public function setAuthor(Author $author): Comment
    {
        $this->author = $author->getName();
        $this->authorUrl = $author->getUrl();
        $this->authorIp = $author->getIp();
        $this->authorEmail = $author->getEmail();
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Comment
     */
    public function setDate(DateTime $date): Comment
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateGMT(): DateTime
    {
        return $this->dateGMT;
    }

    /**
     * @param DateTime $dateGMT
     * @return Comment
     */
    public function setDateGMT(DateTime $dateGMT): Comment
    {
        $this->dateGMT = $dateGMT;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getKarma(): int
    {
        return $this->karma;
    }

    /**
     * @param int $karma
     * @return Comment
     */
    public function setKarma(int $karma): Comment
    {
        $this->karma = $karma;
        return $this;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     * @return Comment
     */
    public function setApproved(bool $approved): Comment
    {
        $this->approved = $approved;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgent(): string
    {
        return $this->agent;
    }

    /**
     * @param string $agent
     * @return Comment
     */
    public function setAgent(string $agent): Comment
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Comment
     */
    public function setType(string $type): Comment
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getParent(): ?Comment
    {
        return $this->parent;
    }

    /**
     * @param Comment|null $parent
     * @return Comment
     */
    public function setParent(?Comment $parent): Comment
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Comment[]
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * @param Comment[] $childs
     * @return Comment
     */
    public function setChilds(array $childs): Comment
    {
        $this->childs = $childs;
        return $this;
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
     * @return Comment
     */
    public function setUser(User $user): Comment
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CommentMeta[]
     */
    public function getMetas(): array
    {
        return $this->metas;
    }

    /**
     * @param CommentMeta[] $metas
     * @return Comment
     */
    public function setMetas(array $metas): Comment
    {
        $this->metas = $metas;
        return $this;
    }
}