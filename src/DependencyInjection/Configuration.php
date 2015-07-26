<?php

namespace Maba\Bundle\AvatarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('maba_avatar');

        $children = $rootNode->children();

        $children->scalarNode('default_uri')->defaultNull();
        $children->scalarNode('default_size')->defaultValue(50);

        $gravatar = $children->arrayNode('gravatar')->addDefaultsIfNotSet()->children();
        $gravatar->booleanNode('enabled')->defaultTrue();
        $gravatar->booleanNode('secure')->defaultFalse();
        $gravatar->booleanNode('force_default')->defaultFalse();
        $gravatar->enumNode('default')->defaultValue('mm')->values(array(
            '404',
            'mm',
            'identicon',
            'monsterid',
            'wavatar',
            'retro',
            'blank',
        ));
        $gravatar->enumNode('rating')->defaultNull()->values(array(
            null,
            'g',
            'pg',
            'r',
            'x',
        ));

        return $treeBuilder;
    }
}
