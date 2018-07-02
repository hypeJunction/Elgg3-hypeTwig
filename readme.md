hypeTwig
========
![Elgg 3.0](https://img.shields.io/badge/Elgg-3.0.x-orange.svg?style=flat-square)

Adds support for twig templates in Elgg

## Using Templates

To add a twig template, simply add a file with ``.twig`` extension into your plugin's views, under ``default`` viewtype.

```html
<!-- my_plugins/views/default/test.twig -->

<div class="hello">{{ Hello, {{ name }}</div>
```

To render a template use ``elgg_twig()`:

```php
$user = elgg_get_logged_in_user_entity();

echo elgg_twig('test', ['name' => $user->getDispayName()];
```

You can override templates like any other view, but you can not extend them or filter them using hooks.

## Development

To simplify development, set ``environment`` config value to ``development``, otherwise you need to flush caches to reload template changes.

```php
elgg_set_config('environment', 'development');
```

## Globals

Globals available in templates

* ``app`` - application data
   - ``app.user`` - logged in user entity
   - ``app.site`` - site entity
   - ``app.registrationUrl`` - registration URL
   - ``app.loginUrl`` - login URL

* ``faker`` - fake data generator (https://github.com/fzaninotto/Faker)

## Functions

Function available in templates

* ``echo()`` - equivalent of ``elgg_echo()``
* ``view()`` - equivalent of ``elgg_view()``
* ``assetUrl()`` - equivalent of ``elgg_get_simplecache_url()``
* ``requireJs()`` - equivalent of ``elgg_require_js()``
* ``formatHtml()`` - equivalent of ``elgg_format_html()``

## Notes

I have initially taught ``elgg_view()`` to render twig templates, but it had a negative
performance impact, likely because of a ``view_vars`` hook registered for all views. 
Until there is a wildcard hook registration, ``elgg_twig()`` is the way to go, 
however it does not allow view vars to be filtered or views to be extended, which in the end
is somewhat a win, because of simplicity.



