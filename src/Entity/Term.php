<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Term
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="terms")
 */
class Term
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint", name="term_id")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", name="name")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", name="slug")
     */
    private string $slug;

    /**
     * @ORM\Column(type="integer", name="term_group")
     */
    private int $termGroup;

    /**
     * @var TermMeta[]
     * @ORM\OneToMany(targetEntity="TermMeta", mappedBy="term")
     */
    private array $metas;

    /**
     * @var TermTaxonomy[]
     * @ORM\OneToMany(targetEntity="TermTaxonomy", mappedBy="term")
     */
    private array $taxonomies;

    public function __construct()
    {
        $this->metas = [];
        $this->taxonomies = [];
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Term
     */
    public function setName(string $name): Term
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Term
     */
    public function setSlug(string $slug): Term
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int
     */
    public function getTermGroup(): int
    {
        return $this->termGroup;
    }

    /**
     * @param int $termGroup
     * @return Term
     */
    public function setTermGroup(int $termGroup): Term
    {
        $this->termGroup = $termGroup;
        return $this;
    }

    /**
     * @return TermMeta[]
     */
    public function getMetas(): array
    {
        return $this->metas;
    }

    /**
     * @param TermMeta[] $metas
     * @return Term
     */
    public function setMetas(array $metas): Term
    {
        $this->metas = $metas;
        return $this;
    }

    /**
     * @return TermTaxonomy[]
     */
    public function getTaxonomies(): array
    {
        return $this->taxonomies;
    }

    /**
     * @param TermTaxonomy[] $taxonomies
     * @return Term
     */
    public function setTaxonomies(array $taxonomies): Term
    {
        $this->taxonomies = $taxonomies;
        return $this;
    }
}