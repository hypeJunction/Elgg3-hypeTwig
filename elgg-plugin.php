<?php

require_once __DIR__ . '/lib/functions.php';

return [
	'plugin' => [
		'name' => 'hypeTwig',
		'version' => '4.0.0',
	],

	'bootstrap' => \hypeJunction\Twig\Bootstrap::class,
];
