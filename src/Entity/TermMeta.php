<?php

namespace Hyperion\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TermMeta
 * @package Hyperion\Core\Entity
 * @ORM\Entity()
 * @ORM\Table(name="termmeta", indexes={
 *     @Index(name="meta_key", columns={"meta_key"}),
 *     @Index(name="term_id", columns={"term_id"})
 * })
 */
class TermMeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint", name="meta_id", options={"unsigned": true})
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Term", inversedBy="metas")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="term_id")
     */
    private Term $term;

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
     * @return Term
     */
    public function getTerm(): Term
    {
        return $this->term;
    }

    /**
     * @param Term $term
     * @return TermMeta
     */
    public function setTerm(Term $term): TermMeta
    {
        $this->term = $term;
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
     * @return TermMeta
     */
    public function setKey(string $key): TermMeta
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
     * @return TermMeta
     */
    public function setValue(string $value): TermMeta
    {
        $this->value = $value;
        return $this;
    }

}