<?php

namespace Maba\Bundle\AvatarBundle\Tests\Fixtures;

use Maba\Bundle\AvatarBundle\Service\AvatarProviderInterface;

class TestAvatarProvider implements AvatarProviderInterface
{
    /**
     * @var string|null
     */
    private $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function getAvatar($email, $size)
    {
        if ($this->prefix === null) {
            return null;
        }
        return $this->prefix . ' ' . $email . ' ' . $size;
    }
}
