<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TermTaxonomy
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="term_taxonomy")
 */
class TermTaxonomy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="term_taxonomy_id")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Term", inversedBy="taxonomies")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="term_id")
     */
    private Term $term;

    /**
     * @ORM\Column(name="taxonomy", type="string")
     */
    private string $taxonomy;

    /**
     * @ORM\Column(name="description", type="string")
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity="TermTaxonomy", inversedBy="childs", cascade={"persist", "remove"}))
     * @ORM\JoinColumn(name="parent", referencedColumnName="term_taxonomy_id")
     */
    private TermTaxonomy $parent;

    /**
     * @var TermTaxonomy[]
     * @ORM\OneToMany(targetEntity="TermTaxonomy", mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     */
    private Collection $childs;

    /**
     * @ORM\Column(type="integer", name="count")
     */
    private int $count;

    public function __construct()
    {
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
     * @return Term
     */
    public function getTerm(): Term
    {
        return $this->term;
    }

    /**
     * @param Term $term
     * @return TermTaxonomy
     */
    public function setTerm(Term $term): TermTaxonomy
    {
        $this->term = $term;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxonomy(): string
    {
        return $this->taxonomy;
    }

    /**
     * @param string $taxonomy
     * @return TermTaxonomy
     */
    public function setTaxonomy(string $taxonomy): TermTaxonomy
    {
        $this->taxonomy = $taxonomy;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return TermTaxonomy
     */
    public function setDescription(string $description): TermTaxonomy
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return TermTaxonomy
     */
    public function getParent(): TermTaxonomy
    {
        return $this->parent;
    }

    /**
     * @param TermTaxonomy $parent
     * @return TermTaxonomy
     */
    public function setParent(TermTaxonomy $parent): TermTaxonomy
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return TermTaxonomy[]
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * @param TermTaxonomy[] $childs
     * @return TermTaxonomy
     */
    public function setChilds(array $childs): TermTaxonomy
    {
        $this->childs = $childs;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return TermTaxonomy
     */
    public function setCount(int $count): TermTaxonomy
    {
        $this->count = $count;
        return $this;
    }
}