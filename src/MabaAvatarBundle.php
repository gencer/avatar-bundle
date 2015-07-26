<?php

namespace Maba\Bundle\AvatarBundle;

use Maba\Component\DependencyInjection\AddTaggedByPriorityCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MabaAvatarBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddTaggedByPriorityCompilerPass(
            'maba_avatar.avatar_manager',
            'maba_avatar.avatar_provider',
            'registerAvatarProvider'
        ));
    }
}
