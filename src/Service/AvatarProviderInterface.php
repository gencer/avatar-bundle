<?php

namespace Maba\Bundle\AvatarBundle\Service;

interface AvatarProviderInterface
{

    /**
     * Returns avatar URI for given email in given size (image should be a square)
     * If avatar is unavailable, returns null
     *
     * @param string $email
     * @param integer $size
     *
     * @return string|null
     */
    public function getAvatar($email, $size);
}
