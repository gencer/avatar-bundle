<?php

namespace Maba\Bundle\AvatarBundle\Tests;

use Maba\Bundle\AvatarBundle\Tests\Fixtures\AppKernel;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\Filesystem\Filesystem;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppKernel
     */
    protected $kernel;

    protected function tearDown()
    {
        if ($this->kernel !== null) {
            $fs = new Filesystem();
            $fs->remove($this->kernel->getCacheDir());
        }
    }

    protected function createClient($configurationFile)
    {
        // build environment from parameters as tests are not isolated
        $this->kernel = $kernel = new AppKernel(
            'maba_avatar_test' . str_replace('.', '_', $configurationFile),
            true,
            $configurationFile
        );

        $kernel->boot();

        /** @var Client $client */
        $client = $kernel->getContainer()->get('test.client');

        $client->request('GET', 'http://example.com/test');

        return $client;
    }

    /**
     * Tests via twig function with different bundle configuration options
     * Twig template is static and only content is avatar URI for test@example.com
     *
     * @param string $expected
     * @param string $configurationFile
     *
     * @dataProvider dataProvider
     */
    public function test($expected, $configurationFile)
    {
        $client = $this->createClient($configurationFile);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Response is not successful');
        $this->assertSame(
            $expected,
            $client->getResponse()->getContent()
        );
    }

    public function dataProvider()
    {
        return array(
            'Gets 50x50 gravatar with default configuration' => array(
                'http://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0.jpg?s=50&d=mm',
                'config.yml',
            ),
            'Gets customized gravatar' => array(
                'https://secure.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0.jpg?s=100&d=404&r=x&f=y',
                'config_customized.yml',
            ),
            'Gravatar takes into account default uri' => array(
                'http://www.gravatar.com/avatar/55502f40dc8b7c769880b10874abc9d0.jpg?s=50&d=http%3A%2F%2Fexample.com%2Favatar.jpg',
                'config_gravatar_default_uri.yml',
            ),
            'Gravatar can be disabled' => array(
                '',
                'config_gravatar_disabled.yml',
            ),
            'Provider can be registered' => array(
                'provider1 test@example.com 50',
                'config_provider.yml',
            ),
            'Registers providers by given priority' => array(
                'provider2 test@example.com 50',
                'config_provider_priority.yml',
            ),
            'Falls back to other provider if first provides no avatar' => array(
                'provider1 test@example.com 50',
                'config_provider_fallback.yml'
            ),
            'If no provider gives avatar, returns default uri' => array(
                '/avatar.jpg',
                'config_default_uri.yml',
            ),
        );
    }
}
