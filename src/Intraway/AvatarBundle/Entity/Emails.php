<?php

namespace Intraway\AvatarBundle\Entity;

/**
 * Emails
 */
class Emails
{
    /**
     * @var string
     */
    private $hashmd5;

    /**
     * @var \Intraway\AvatarBundle\Entity\Avatars
     */
    private $idavatar;


    /**
     * Set hashmd5
     *
     * @param string $hashmd5
     *
     * @return Emails
     */
    public function setHashmd5($hashmd5)
    {
        $this->hashmd5 = $hashmd5;

        return $this;
    }

    /**
     * Get hashmd5
     *
     * @return string
     */
    public function getHashmd5()
    {
        return $this->hashmd5;
    }

    /**
     * Set idavatar
     *
     * @param \Intraway\AvatarBundle\Entity\Avatars $idavatar
     *
     * @return Emails
     */
    public function setIdavatar(\Intraway\AvatarBundle\Entity\Avatars $idavatar = null)
    {
        $this->idavatar = $idavatar;

        return $this;
    }

    /**
     * Get idavatar
     *
     * @return \Intraway\AvatarBundle\Entity\Avatars
     */
    public function getIdavatar()
    {
        return $this->idavatar;
    }
}

