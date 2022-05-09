<?php

namespace Hyperion\Doctrine\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Post
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="posts")
 */
class Post
{
    const STATUS_PUBLISH = 'publish';
    const STATUS_FUTURE = 'future';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PRIVATE = 'private';
    const STATUS_TRASH = 'trash';
    const STATUS_AUTODRAFT = 'auto-draft';
    const STATUS_INHERIT = 'inherit';

    /** @var PostMeta[] */
    private ?array $indexedMetas = null;

    /**
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="ID", options={"unsigned": true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="post_author", referencedColumnName="ID")
     */
    private User $author;

    /**
     * @ORM\Column(type="datetime", name="post_date")
     */
    private DateTime $date;

    /**
     * @ORM\Column(type="datetime", name="post_date_gmt")
     */
    private Datetime $dateGMT;

    /**
     * @ORM\Column(type="string", name="post_content")
     */
    private string $content = "";

    /**
     * @ORM\Column(type="string", name="post_title")
     */
    private string $title = "";

    /**
     * @ORM\Column(type="string", name="post_excerpt")
     */
    private string $excerpt = "";

    /**
     * @ORM\Column(type="string", name="post_status")
     */
    private string $status = "";

    /**
     * @ORM\Column(type="string", name="comment_status")
     */
    private string $commentStatus = "";

    /**
     * @ORM\Column(type="string", name="ping_status")
     */
    private string $pingStatus = "";

    /**
     * @ORM\Column(type="string", name="post_password")
     */
    private string $password = "";

    /**
     * @ORM\Column(type="string", name="post_name")
     */
    private string $name = "";

    /**
     * @ORM\Column(type="string", name="to_ping")
     */
    private string $toPing = "";

    /**
     * @ORM\Column(type="string", name="pinged")
     */
    private string $pinged = "";

    /**
     * @ORM\Column(type="datetime", name="post_modified")
     */
    private ?DateTime $modified = null;

    /**
     * @ORM\Column(type="datetime", name="post_modified_gmt")
     * @todo: Découvrir comment dans la base il peut y avoir des null sur un not null
     */
    private DateTime $modifiedGMT;

    /**
     * @ORM\Column(type="string", name="post_content_filtered")
     */
    private string $contentFiltered = "";

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="childs", cascade={"persist", "remove"}))
     * @ORM\JoinColumn(name="post_parent", referencedColumnName="ID", nullable=true)
     */
    private ?Post $parent = null;

    /**
     * @var Post[];
     * @ORM\OneToMany(targetEntity="Post", mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     */
    private Collection $childs;

    /**
     * @ORM\Column(type="string", name="guid")
     */
    private string $guid = "";

    /**
     * @ORM\Column(type="integer", name="menu_order")
     */
    private int $menuOrder = 0;

    /**
     * @ORM\Column(type="string", name="post_type")
     */
    private string $postType = "post";

    /**
     * @ORM\Column(type="string", name="post_mime_type")
     */
    private string $postMimeType = "";

    /**
     * @ORM\Column(type="integer", name="comment_count")
     */
    private int $commentCount = 0;

    /**
     * @var Comment[]
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"persist"})
     */
    private Collection $comments;

    /**
     * @var PostMeta[]
     * @ORM\OneToMany(targetEntity="PostMeta", mappedBy="post", cascade={"persist"}, fetch="EAGER")
     */
    private Collection $metas;

    public function __construct()
    {
        $now = new DateTime();
        $this->setDate($now);
        $this->setModified($now);
        $this->setDateGMT($now->setTimezone(new \DateTimeZone('GMT')));
        $this->setModifiedGMT($now->setTimezone(new \DateTimeZone('GMT')));
        $this->metas = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->childs = new ArrayCollection();
    }

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
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Post
     */
    public function setAuthor(User $author): Post
    {
        $this->author = $author;
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
     * @return Post
     */
    public function setDate(DateTime $date): Post
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
     * @return Post
     */
    public function setDateGMT(DateTime $dateGMT): Post
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
     * @return Post
     */
    public function setContent(string $content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    /**
     * @param string $excerpt
     * @return Post
     */
    public function setExcerpt(string $excerpt): Post
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Post
     */
    public function setStatus(string $status): Post
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentStatus(): string
    {
        return $this->commentStatus;
    }

    /**
     * @param string $commentStatus
     * @return Post
     */
    public function setCommentStatus(string $commentStatus): Post
    {
        $this->commentStatus = $commentStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getPingStatus(): string
    {
        return $this->pingStatus;
    }

    /**
     * @param string $pingStatus
     * @return Post
     */
    public function setPingStatus(string $pingStatus): Post
    {
        $this->pingStatus = $pingStatus;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Post
     */
    public function setPassword(string $password): Post
    {
        $this->password = $password;
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
     * @return Post
     */
    public function setName(string $name): Post
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getToPing(): string
    {
        return $this->toPing;
    }

    /**
     * @param string $toPing
     * @return Post
     */
    public function setToPing(string $toPing): Post
    {
        $this->toPing = $toPing;
        return $this;
    }

    /**
     * @return string
     */
    public function getPinged(): string
    {
        return $this->pinged;
    }

    /**
     * @param string $pinged
     * @return Post
     */
    public function setPinged(string $pinged): Post
    {
        $this->pinged = $pinged;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getModified(): DateTime
    {
        return $this->modified;
    }

    /**
     * @param DateTime $modified
     * @return Post
     */
    public function setModified(DateTime $modified): Post
    {
        $this->modified = $modified;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getModifiedGMT(): ?DateTime
    {
        return $this->modifiedGMT;
    }

    /**
     * @param DateTime $modifiedGMT
     * @return Post
     */
    public function setModifiedGMT(?DateTime $modifiedGMT): Post
    {
        $this->modifiedGMT = $modifiedGMT;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentFiltered(): string
    {
        return $this->contentFiltered;
    }

    /**
     * @param string $contentFiltered
     * @return Post
     */
    public function setContentFiltered(string $contentFiltered): Post
    {
        $this->contentFiltered = $contentFiltered;
        return $this;
    }

    /**
     * @return Post|null
     */
    public function getParent(): ?Post
    {
        return $this->parent;
    }

    /**
     * @param Post|null $parent
     * @return Post
     */
    public function setParent(?Post $parent): Post
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Post[]
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    /**
     * @param Post[]|null $childs
     * @return Post
     */
    public function setChilds(Collection $childs): Post
    {
        $this->childs = $childs;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     * @return Post
     */
    public function setGuid(string $guid): Post
    {
        $this->guid = $guid;
        return $this;
    }

    /**
     * @return int
     */
    public function getMenuOrder(): int
    {
        return $this->menuOrder;
    }

    /**
     * @param int $menuOrder
     * @return Post
     */
    public function setMenuOrder(int $menuOrder): Post
    {
        $this->menuOrder = $menuOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostType(): string
    {
        return $this->postType;
    }

    /**
     * @param string $postType
     * @return Post
     */
    public function setPostType(string $postType): Post
    {
        $this->postType = $postType;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostMimeType(): string
    {
        return $this->postMimeType;
    }

    /**
     * @param string $postMimeType
     * @return Post
     */
    public function setPostMimeType(string $postMimeType): Post
    {
        $this->postMimeType = $postMimeType;
        return $this;
    }

    /**
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    /**
     * @param int $commentCount
     * @return Post
     */
    public function setCommentCount(int $commentCount): Post
    {
        $this->commentCount = $commentCount;
        return $this;
    }

    /**
     * @return Comment[]|null
     */
    public function getComments(): ?Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     * @return Post
     */
    public function setComments(Collection $comments): Post
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return Collection|null|PostMeta[]
     */
    public function getMetas() : ?Collection
    {
        return $this->metas;
    }

    public function getMeta(string $key) : ?string
    {
        $indexedMetas = $this->getIndexMetas();
        return $indexedMetas[$key] ?? null;
    }

    public function setMetas(Collection $metas)
    {
        $this->metas = $metas;
    }

    /**
     * @param PostMeta $meta
     */
    public function addMeta(PostMeta $meta)
    {
        $indexedMetas = $this->getIndexMetas();
        if(array_key_exists($meta->getKey(), $indexedMetas)) {
            $indexedMetas[$meta->getKey()]->setValue($meta->getValue());
        } else {
            $this->metas->add($meta->setPost($this));
        }

        return $this;
    }

    /**
     * @param PostMeta $meta
     */
    public function removeMeta(PostMeta $meta)
    {
        if (false !== $key = array_search($meta, $this->metas, true)) {
            array_splice($this->metas, $key, 1);
        }
    }

    //@todo: duplicate on User entity
    private function getIndexMetas()
    {
        if(is_null($this->indexedMetas)) {
            $this->indexedMetas = [];
            foreach($this->metas as $meta) {
                $this->indexedMetas[$meta->getKey()] = $meta;
            }
        }

        return $this->indexedMetas;
    }

    public function __toString()
    {
        return "title : $this->title, type : $this->postType, name : $this->name";
    }
}