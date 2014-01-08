<?php

namespace Kayue\WordpressBundle\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class AttachmentManager //implements AttachmentManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    protected $postMetaManager;

    /**
     * Constructor.
     *
     * @param EntityManager     $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository('KayueWordpressBundle:Post');
        $this->postMetaManager = new PostMetaManager($em);
    }

    /**
     * @param Post $post
     *
     * @return AttachmentInterface[]
     */
    public function findAttachmentsByPost(Post $post)
    {
        $posts = $this->repository->findBy(array(
            'parent' => $post,
            'type'   => 'attachment',
        ));

        $result = array();
        /** @var $post Post */
        foreach ($posts as $post) {
            /** @var $meta PostMeta */
            $meta = $this->postMetaManager->findOneMetaBy(array(
                'post' => $post,
                'key'  => '_wp_attachment_metadata'
            ));

            if ($meta) {
                $rawMeta = $meta->getValue();
                $attachment = new Attachment($post);

                $attachment->setUrl($rawMeta['file']);
                if (isset($rawMeta['sizes']['thumbnail'])) {
                    $attachment->setThumbnailUrl(substr($rawMeta['file'], 0, strrpos($rawMeta['file'], '/') + 1) . $rawMeta['sizes']['thumbnail']['file']);
                }

                $result[] = $attachment;
            }
        }

        return $result;
    }

    /**
     * @param $id integer
     *
     * @return AttachmentInterface
     */
    public function findOneAttachmentById($id, $size )
    {
        $post = $this->repository->findOneBy(array(
            'id'     => $id,
            'type'   => 'attachment',
        ));

        /** @var $meta PostMeta */
        $meta = $this->postMetaManager->findOneMetaBy(array(
            'post' => $post,
            'key'  => '_wp_attachment_metadata'
        ));
        //var_dump($id, $size, $meta->getValue());exit;
        if ($meta) {
            $rawMeta = $meta->getValue();
            $attachment = new Attachment($post);

            $attachment->setUrl($rawMeta['file']);
            if (isset($rawMeta['sizes'][$size])) {
                $attachment->setThumbnailUrl(substr($rawMeta['file'], 0, strrpos($rawMeta['file'], '/') + 1) . $rawMeta['sizes'][$size]['file']);
            }
            return $attachment;
        }

        return null;
    }

    public function getAttachmentOfSize(Attachment $attachment, $size = null)
    {
        if($size === 'full') {
            return $attachment->getUrl();
        }

        /** @var $meta PostMeta */
        $meta = $this->postMetaManager->findOneMetaBy(array(
            'post' => $attachment,
            'key'  => '_wp_attachment_metadata'
        ));

        if (!$meta) {
            return null;
        }

        $rawMeta = $meta->getValue();

        $chosenSize = null;
        $min = 999999;
        foreach ($rawMeta['sizes'] as $meta) {
            if ($meta['width'] >= $size[0] && $meta['height'] >= $size[1]) {
                $dimensionDiff = $meta['width'] - $size[0] + $meta['height'] - $size[1];
                if ($dimensionDiff < $min) {
                    $chosenSize = $meta;
                    $min = $dimensionDiff;
                }
            }
        }

        if ($chosenSize) {
            return substr($rawMeta['file'], 0, strrpos($rawMeta['file'], '/') + 1) . $chosenSize['file'];
        } else {
            return $attachment->getUrl();
        }
    }

    /**
     * @param $post
     * @param array $size A 2-item array representing width and height in pixels, e.g. array(32,32).
     *
     * @return mixed
     */
    public function findFeaturedImageByPost($post, $size)
    {
        $featuredImageId = $this->postMetaManager->findOneMetaBy(array(
            'post' => $post,
            'key'  => '_thumbnail_id'
        ));

        if (!$featuredImageId) return null;

        return $this->findOneAttachmentById($featuredImageId->getValue(), $size);
    }

    public function findFeaturedVideoByLink($link)
    {
        preg_match("/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/", $link, $matches);
        if (isset($matches[7]) && strlen($matches[7]) == 11)
            return "http://www.youtube.com/embed/{$matches[7]}?feature=oembed&HD=1;rel=0";
        return '';
    }
}