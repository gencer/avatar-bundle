<?php

namespace Maba\Bundle\AvatarBundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{

    public function testAction()
    {
        return $this->render(__DIR__ . '/view.twig');
    }
}
