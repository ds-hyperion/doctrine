<?php

namespace Hyperion\Doctrine\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Class User
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{
    /** @var UserMeta[] */
    private ?array $indexedMetas = null;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer", name="ID")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="user_login")
     */
    private string $login;

    /**
     * @ORM\Column(type="string", name="user_pass")
     */
    private string $pass;

    /**
     * @ORM\Column(type="string", name="user_nicename")
     */
    private string $nicename;

    /**
     * @ORM\Column(type="string", name="user_email")
     */
    private string $email;

    /**
     * @ORM\Column(type="string", name="user_url")
     */
    private string $url;

    /**
     * @ORM\Column(type="datetime", name="user_registered")
     */
    private DateTime $registeredDate;

    /**
     * @ORM\Column(type="string", name="user_activation_key")
     */
    private string $activationKey;

    /**
     * @ORM\Column(type="integer", name="user_status")
     */
    private int $status;

    /**
     * @ORM\Column(type="string", name="display_name")
     */
    private string $displayName;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Link", mappedBy="owner", cascade={"persist"})
     */
    private Collection $links;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"persist"})
     */
    private Collection $comments;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author", cascade={"persist"})
     */
    private Collection $posts;

    /**
     * @var UserMeta[]
     * @ORM\OneToMany(targetEntity="UserMeta", mappedBy="user", cascade={"persist"})
     */
    private Collection $metas;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->metas = new ArrayCollection();
        $this->setRegisteredDate(new DateTime());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return User
     */
    public function setPass(string $pass): User
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return string
     */
    public function getNicename(): string
    {
        return $this->nicename;
    }

    /**
     * @param string $nicename
     * @return User
     */
    public function setNicename(string $nicename): User
    {
        $this->nicename = $nicename;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return User
     */
    public function setUrl(string $url): User
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRegisteredDate(): DateTime
    {
        return $this->registeredDate;
    }

    /**
     * @param DateTime $registeredDate
     * @return User
     */
    public function setRegisteredDate(DateTime $registeredDate): User
    {
        $this->registeredDate = $registeredDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivationKey(): string
    {
        return $this->activationKey;
    }

    /**
     * @param string $activationKey
     * @return User
     */
    public function setActivationKey(string $activationKey): User
    {
        $this->activationKey = $activationKey;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return User
     */
    public function setStatus(int $status): User
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return User
     */
    public function setDisplayName(string $displayName): User
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): ?Collection
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     * @return User
     */
    public function setLinks(Collection $links): User
    {
        $this->links = $links;
        return $this;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     * @return User
     */
    public function setComments(Collection $comments): User
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post[] $posts
     * @return User
     */
    public function setPosts(Collection $posts): User
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @return Collection|null|UserMeta[]
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
     * @param UserMeta $meta
     */
    public function addMeta(UserMeta $meta)
    {
        $indexedMetas = $this->getIndexMetas();
        if(array_key_exists($meta->getKey(), $indexedMetas)) {
            $indexedMetas[$meta->getKey()]->setValue($meta->getValue());
        } else {
            $this->metas->add($meta->setUser($this));
        }

        return $this;
    }

    /**
     * @param UserMeta $meta
     */
    public function removeMeta(UserMeta $meta)
    {
        if (false !== $key = array_search($meta, $this->metas, true)) {
            array_splice($this->metas, $key, 1);
        }
    }

    //@todo: duplicate on Post entity
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
}