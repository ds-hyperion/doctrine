<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TermRelationship
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="term_relationships"indexes={
 *     @Index(name="term_taxonomy_id", columns={"term_taxonomy_id"})
 * })
 */
class TermRelationship
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="bigint", name="object_id")
     */
    private int $objectId;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="TermTaxonomy")
     * @ORM\JoinColumn(name="term_taxonomy_id", referencedColumnName="term_taxonomy_id")
     */
    private TermTaxonomy $termTaxonomy;

    /**
     * @ORM\Column(name="term_order", type="integer", options={"default": 0})
     */
    private int $order;

    /**
     * @return int
     */
    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @param int $objectId
     * @return TermRelationship
     */
    public function setObjectId(int $objectId): TermRelationship
    {
        $this->objectId = $objectId;
        return $this;
    }

    /**
     * @return TermTaxonomy
     */
    public function getTermTaxonomy(): TermTaxonomy
    {
        return $this->termTaxonomy;
    }

    /**
     * @param TermTaxonomy $termTaxonomy
     * @return TermRelationship
     */
    public function setTermTaxonomy(TermTaxonomy $termTaxonomy): TermRelationship
    {
        $this->termTaxonomy = $termTaxonomy;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return TermRelationship
     */
    public function setOrder(int $order): TermRelationship
    {
        $this->order = $order;
        return $this;
    }
}