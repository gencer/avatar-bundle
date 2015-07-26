<?php

namespace Maba\Bundle\AvatarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MabaAvatarExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('maba_avatar.default_uri', $config['default_uri']);
        $container->setParameter('maba_avatar.default_size', $config['default_size']);

        $gravatarConfig = $config['gravatar'];

        if ($gravatarConfig['enabled']) {
            $loader->load('services/gravatar.xml');
            $container->setParameter('maba_avatar.gravatar.secure', $gravatarConfig['secure']);
            $container->setParameter('maba_avatar.gravatar.force_default', $gravatarConfig['force_default']);
            $container->setParameter('maba_avatar.gravatar.default', $gravatarConfig['default']);
            $container->setParameter('maba_avatar.gravatar.rating', $gravatarConfig['rating']);
        }
    }
}
