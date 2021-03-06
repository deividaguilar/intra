<?php

namespace Intraway\AvatarBundle\Entity;

/**
 * Avatars
 */
class Avatars
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $mimetype;

    /**
     * @var integer
     */
    private $size;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Avatars
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Avatars
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set mimetype
     *
     * @param string $mimetype
     *
     * @return Avatars
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;

        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Avatars
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * @var integer
     */
    private $sizefile;

    /**
     * @var string
     */
    private $extension;


    /**
     * Set sizefile
     *
     * @param integer $sizefile
     *
     * @return Avatars
     */
    public function setSizefile($sizefile)
    {
        $this->sizefile = $sizefile;

        return $this;
    }

    /**
     * Get sizefile
     *
     * @return integer
     */
    public function getSizefile()
    {
        return $this->sizefile;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Avatars
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Avatars
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var string
     */
    private $thumb;


    /**
     * Set thumb
     *
     * @param string $thumb
     *
     * @return Avatars
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }
}
