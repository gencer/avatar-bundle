<?php

namespace Maba\Bundle\AvatarBundle\Tests\Fixtures;

use Maba\Bundle\AvatarBundle\MabaAvatarBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    /**
     * @var string
     */
    private $configurationFile;

    public function __construct($environment, $debug, $configurationFile = 'config.yml')
    {
        parent::__construct($environment, $debug);
        $this->configurationFile = $configurationFile;
    }


    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new TwigBundle(),
            new MabaAvatarBundle()
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/Resources/' . $this->configurationFile);
    }
}
