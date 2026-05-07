<?php

// (4.x) PhpDiResolver and DI\object() were removed. The 'views' rebind
// is no longer needed — Elgg's ViewsService is reachable via elgg()->
// views from any application-level code, and the factory closure below
// resolves it at construction time. DI\object(X) is rewritten as
// DI\create(X).
return [
	'twig.loader' => \DI\factory(function () {
		return new \hypeJunction\Twig\ViewLoader(elgg()->views);
	}),
	'twig' => \DI\create(\hypeJunction\Twig\Twig::class)
		->constructor(
			\DI\get('twig.loader'),
			[
				'cache' => elgg_get_cache_path() . 'twig/',
				'debug' => elgg_get_config('environment') === 'development',
				'auto_reload' => elgg_get_config('environment') === 'development',
			]
		)
		->method('setup'),
];
