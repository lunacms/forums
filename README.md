# Forums for Laravel Apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lunacms/forums.svg?style=flat-square)](https://packagist.org/packages/lunacms/forums)
[![Total Downloads](https://img.shields.io/packagist/dt/lunacms/forums.svg?style=flat-square)](https://packagist.org/packages/lunacms/forums)
![GitHub Actions](https://github.com/lunacms/forums/actions/workflows/main.yml/badge.svg)

An `API` first forums package that allows running a single forum or multiple forums within your Laravel app. Supports Laravel 8 and above.

## Installation

You can install the package via composer:

```bash
composer require lunacms/forums
```

You 

Then run migrate command:

```
php artisan migrate
```

## Configuration

To customize the package usage, copy the package config to your local config by using the publish command:

```
php artisan vendor:publish --tag=forums-config
```

> You can configure your models, resources and morph map (for polymorphic relationships) there.

## Usage

### Traits

- `CanCommentTrait` for model to post, update, reply or delete comments.
- `OwnsForumTrait` for model to own a forum.

Add both traits to your `User` model.

> By default the package uses the authenticated request user as owner of forum, posts and comments.

### Running in Single Mode

Set `mode` option value to `single` in `config/forums.php`.

```php
mode='single'
```

Call `runInSingleMode()` in `boot` method of `AppServiceProvider`.

```php
Forums::runInSingleMode();
```

### Routes

**Note**: The enclosed `{CUSTOM_PREFIX}` is a prefix which can be changed in the `forums` config 
`route` prefix.

#### Securing Routes

You can secure the package routes by setting the relevant middleware 
in the config file, under routes settings.

There are two options:

- `middleware`: Key used to set the general routing and bindings, default is `web`
- `auth_middleware`: Used for authenticating users who create forums, posts and comments.
Default is `auth`.

#### Comment Routes

They accept an `id` as parameter and `body` in the request data (except `destroy`) route.

- `{CUSTOM_PREFIX}/comments/{comment}`:  Handle comment update; `PUT|PATCH`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/comments/{comment}`:  Handle comment destroy; `DELETE`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/comments/{comment}/replies`:  Handle comment reply store; `POST`
                                                                                                                                                           
#### Forums Routes

Handles forum functionality when `mode` is `multi`.

For `post` and `put|patch` routes, a `name` is required, and optional `tags` array.

When displaying, updating, or deleting a `slug` is passed as route param.

- `{CUSTOM_PREFIX}/forums`:  Handles forums listing; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums`:  Handles forum storage; `POST`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums/{slug}`:  Handles showing single forum data; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums/{slug}`:  Handles forum update; `PUT|PATCH`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums/{slug}`:  Handles forum destroy; `DELETE`
                                                                                                                                                           
#### Posts Routes (in multi mode)

Pass **forum** `slug` as route param for all routes below: ie replace `forums:slug`.

An additional `slug` required for the single post display route, use `$post->slug`

- `{CUSTOM_PREFIX}/forums/{forum:slug}/posts`:  Handles a forums posts listing; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums/{forum:slug}/posts`:  Handles a forums post storage; `POST`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/forums/{forum:slug}/posts/{slug}` :  Handles showing of a single post in a forum; `GET|HEAD`
                                                                                                                                                           
#### Posts Route (in single mode)

Post `slug` required for a single post display route.

- `{CUSTOM_PREFIX}/posts`:  Handles a posts listing; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/posts`:  Handles a post storage; `POST`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/posts/{slug}` :  Handles a showing of a forums post; `GET|HEAD`

#### Posts Routes (shared in both modes)

Post `slug` as route param.

- `{CUSTOM_PREFIX}/posts/{slug}`:  Handle post update; `PUT|PATCH`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/posts/{slug}`:  Handle post delete; `DELETE`

#### Post Comment Routes (shared in both modes)

Post `slug` as route param; `body` passed as request data for `POST` route.
                                                                                                                                                           
- `{CUSTOM_PREFIX}/posts/{slug}/comments`:  Handle listing a post's comments; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/posts/{slug}/comments`:  Handle creating a post's comment; `POST`
                                                                                                                                                           
#### Tags

Use `slug` as route params for all routes except `index` and `store`.

Pass `name` as request data for `POST` and `PATCH` routes.

- `{CUSTOM_PREFIX}/tags`:  Handles tags listing; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/tags`:  Handles tags store; `POST`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/tags/{tag}`:  Handles single tag display; `GET|HEAD`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/tags/{tag}`:  Handles tag update; `PUT|PATCH`
                                                                                                                                                           
- `{CUSTOM_PREFIX}/tags/{tag}`:  Handles tag destroy; `DELETE`

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email miracuthbert@gmail.com instead of using the issue tracker.

## Credits

-   [Cuthbert Mirambo](https://github.com/miracuthbert)
-   [All Contributors](../../contributors)

## License

The GNU GPLv3. Please see [License File](LICENSE.md) for more information.
