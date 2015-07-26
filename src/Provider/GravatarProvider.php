<?php

namespace Maba\Bundle\AvatarBundle\Provider;

use Maba\Bundle\AvatarBundle\Service\AvatarProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class GravatarProvider implements AvatarProviderInterface
{
    /**
     * @var string
     */
    protected $default;

    /**
     * @var boolean
     */
    protected $forceDefault;

    /**
     * @var string
     */
    protected $rating;

    /**
     * @var boolean
     */
    protected $secure;

    /**
     * @var integer
     */
    protected $defaultSize;

    /**
     * @var string|null
     */
    protected $defaultUri;

    /**
     * @var Request
     */
    protected $request;

    public function __construct($defaultSize, $default, $defaultUri, $forceDefault, $rating, $secure)
    {
        $this->defaultSize = $defaultSize;
        $this->default = $default;
        $this->defaultUri = $defaultUri;
        $this->forceDefault = $forceDefault;
        $this->rating = $rating;
        $this->secure = $secure;
    }

    /**
     * @param Request|null $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getAvatar($email, $size)
    {
        if ($this->secure) {
            $uri = 'https://secure.gravatar.com/avatar/';
        } else {
            $uri = 'http://www.gravatar.com/avatar/';
        }
        $uri .= md5(strtolower(trim($email))) . '.jpg?';

        $default = $this->default;
        if ($this->defaultUri !== null) {
            if (substr($this->defaultUri, 0, 1) === '/') {
                if ($this->request !== null) {
                    $default = $this->request->getSchemeAndHttpHost() . $this->defaultUri;
                }
            } else {
                $default = $this->defaultUri;
            }
        }

        $query = array(
            's' => $this->defaultSize,
            'd' => $default,
        );

        if ($this->rating !== null) {
            $query['r'] = $this->rating;
        }
        if ($this->forceDefault) {
            $query['f'] = 'y';
        }

        return $uri . http_build_query($query, null, '&');
    }
}
