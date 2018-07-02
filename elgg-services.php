<?php

return [
	'views' => new \Elgg\Di\PhpDiResolver(\Elgg\ViewsService::class, 'views'),
	'twig.loader' => \DI\object(\hypeJunction\Twig\ViewLoader::class)
		->constructor(\DI\get('views')),
	'twig' => \DI\object(\hypeJunction\Twig\Twig::class)
		->constructor(
			\DI\get('twig.loader'),
			[
				'cache' => elgg_get_data_path() . 'twig/',
				'debug' => elgg_get_config('environment') === 'development',
				'auto_reload' => elgg_get_config('environment') === 'development',
			]
		)
		->method('setup'),
];