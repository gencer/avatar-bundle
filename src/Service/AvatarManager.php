<?php

namespace Maba\Bundle\AvatarBundle\Service;

class AvatarManager
{
    /**
     * @var AvatarProviderInterface[]
     */
    protected $providers = array();

    /**
     * @var string
     */
    protected $defaultAvatar;

    public function __construct($defaultSize, $defaultAvatar = null)
    {
        $this->defaultSize = $defaultSize;
        $this->defaultAvatar = $defaultAvatar;
    }

    public function registerAvatarProvider(AvatarProviderInterface $avatarProvider)
    {
        $this->providers[] = $avatarProvider;
    }

    public function getAvatarForEmail($email, $size = null)
    {
        if ($size === null) {
            $size = $this->defaultSize;
        }

        foreach ($this->providers as $provider) {
            $avatar = $provider->getAvatar($email, $size);
            if ($avatar !== null) {
                return $avatar;
            }
        }
        return $this->defaultAvatar;
    }
}
