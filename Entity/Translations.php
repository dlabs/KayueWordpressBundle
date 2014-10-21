<?php

namespace Kayue\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *      name="icl_translations",
 *      indexes={
 *          @ORM\Index(name="trid_lang", columns={"trid", "language_code"}),
 *          @ORM\Index(name="el_type_id", columns={"element_type", "element_id"})
 *      },
 *      uniqueConstraints={
 *      }
 * )
 * @ORM\Entity
 */
class Translations
{
    /**
     * @var int
     *
     * @ORM\Column(name="translation_id", type="bigint", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $translation_id;

    /**
     * @var int
     *
     * @ORM\Column(name="element_type", type="string", length=36, options={"default" = "post_post"})
     */
    protected $element_type;

    /**
     * @var int
     *
     * @ORM\Column(name="element_id", type="bigint", length=20)
     */
    protected $element_id;

    /**
     * @var int
     *
     * @ORM\Column(name="trid", type="bigint", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $tr_id;

    /**
     * @var int
     *
     * @ORM\Column(name="language_code", type="string", length=7)
     */
    protected $language_code;

    /**
     * @var int
     *
     * @ORM\Column(name="source_language_code", type="string", length=7)
     */
    protected $source_language_code;


    /**
     * @return int
     */
    public function getTranslationId()
    {
        return $this->translation_id;
    }

    /**
     * @param int $translation_id
     */
    public function setTranslationId($translation_id)
    {
        $this->translation_id = $translation_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getElementType()
    {
        return $this->element_type;
    }

    /**
     * @param int $element_type
     */
    public function setElementType($element_type)
    {
        $this->element_type = $element_type;

        return $this;
    }

    /**
     * @return int
     */
    public function getElementId()
    {
        return $this->element_id;
    }

    /**
     * @param int $element_id
     */
    public function setElementId($element_id)
    {
        $this->element_id = $element_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getTrId()
    {
        return $this->tr_id;
    }

    /**
     * @param int $tr_id
     */
    public function setTrId($tr_id)
    {
        $this->tr_id = $tr_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * @param int $language_code
     */
    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;

        return $this;
    }

    /**
     * @return int
     */
    public function getSourceLanguageCode()
    {
        return $this->source_language_code;
    }

    /**
     * @param int $source_language_code
     */
    public function setSourceLanguageCode($source_language_code)
    {
        $this->source_language_code = $source_language_code;

        return $this;
    }
}
