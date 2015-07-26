<?php

namespace Maba\Bundle\AvatarBundle\Twig;

use Maba\Bundle\AvatarBundle\Service\AvatarManager;

class AvatarExtension extends \Twig_Extension
{
    protected $avatarManager;

    public function __construct(AvatarManager $avatarManager)
    {
        $this->avatarManager = $avatarManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('avatar_uri', array($this, 'getAvatarUri')),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'maba_avatar';
    }

    public function getAvatarUri($email)
    {
        return $this->avatarManager->getAvatarForEmail($email);
    }
}
