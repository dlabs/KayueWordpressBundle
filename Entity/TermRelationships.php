<?php

namespace Kayue\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="term_relationships")
 * @ORM\Entity
 */
class TermRelationships
{
    /**
     * @var int
     *
     * @ORM\Column(name="object_id", type="bigint", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $object_id;

    /**
     * @var int
     *
     * @ORM\Column(name="term_taxonomy_id", type="bigint", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $term_taxonomy_id;

    /**
     * @var int
     *
     * @ORM\Column(name="term_order", type="integer", length=11)
     */
    protected $term_order;

    /**
     * @return mixed
     */
    public function getObjectId()
    {
        return $this->object_id;
    }

    /**
     * @param mixed $object_id
     */
    public function setObjectId($object_id)
    {
        $this->object_id = $object_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getTermTaxonomyId()
    {
        return $this->term_taxonomy_id;
    }

    /**
     * @param int $term_taxonomy_id
     */
    public function setTermTaxonomyId($term_taxonomy_id)
    {
        $this->term_taxonomy_id = $term_taxonomy_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getTermOrder()
    {
        return $this->term_order;
    }

    /**
     * @param int $term_order
     */
    public function setTermOrder($term_order)
    {
        $this->term_order = $term_order;

        return $this;
    }
}