# Avatar bundle

## What's that?

Symfony2 bundle to get avatar image for given email.

It lets to register additional avatar providers so that most appropriate avatar can be selected.

It includes one default avatar provider - `GravatarProvider`.

## Installing

```shell
composer require maba/avatar-bundle
```

## Configuring

```yml
maba_avatar:
    default_uri: /assets/unknown.png    # defaults to ~
    default_size: 50
    gravatar:
        enabled: true
        secure: false
        force_default: false
        default: mm                     # one of mm, 404, identicon, monsterid, wavatar, retro, blank
                                        # ignored if default_uri is set
        rating: ~                       # one of g, pg, r, x
```

## Adding avatar provider

1. Make class which implements `Maba\Bundle\AvatarBundle\Service\AvatarProviderInterface`.
2, Register it as a service.
3. Add tag `maba_avatar.avatar_provider` to that service.
4. Optionally provide `priority` attribute to that tag. Smallest number means provider will be called first.
    `GravatarProvider` has `priority` `9000`, but always returns URI, so your priorities should be smaller than that.
    If not provided, default to `0`.

Example:

```php
namespace Acme;

use Maba\Bundle\AvatarBundle\Service\AvatarProviderInterface;

class MyAvatarProvider implements AvatarProviderInterface
{
    // ...
    
    public function getAvatar($email, $size)
    {
        $user = $this->repository->findOneByEmail($email);
        if ($user === null) {
            // we don't have avatar - other providers will by called by priority
            return null;
        }
        
        return $this->avatarPath . $user->getAvatar();
    }
    
    // ...
}
```

```xml
<service id="acme.my_avatar_provider" class="Acme\MyAvatarProvider">
    <tag name="maba_avatar.avatar_provider" priority="0"/>
    <!-- any other configuration -->
</service>
```

## Running tests

[![Travis status](https://travis-ci.org/mariusbalcytis/avatar-bundle.svg?branch=master)](https://travis-ci.org/mariusbalcytis/avatar-bundle)

```shell
composer install
vendor/bin/phpunit
```
