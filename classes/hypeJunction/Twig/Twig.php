<?php

namespace hypeJunction\Twig;

use Elgg\Di\ServiceFacade;
use Faker\Factory;
use Twig\Environment;
use Twig\TwigFunction;

class Twig extends Environment {

	use ServiceFacade;

	/**
	 * {@inheritdoc}
	 */
	public static function name() {
		return 'twig';
	}

	/**
	 * Setup environment
	 * @return void
	 */
	public function setup() {
		$this->addGlobal('faker', Factory::create());
		$this->addGlobal('app', new App());

		$this->addFunction(new TwigFunction('echo', 'elgg_echo'));

		$this->addFunction(new TwigFunction('view', 'elgg_view', [
			'pre_escape' => 'html',
			'is_safe' => ['html'],
		]));

		$this->addFunction(new TwigFunction('assetUrl', 'elgg_get_simplecache_url'));

		$this->addFunction(new TwigFunction('requireJs', 'elgg_require_js'));

		$this->addFunction(new TwigFunction('formatHtml', 'elgg_format_html', [
			'pre_escape' => 'html',
			'is_safe' => ['html'],
		]));

		$this->addFunction(new TwigFunction('menu', 'elgg_view_menu', [
			'pre_escape' => 'html',
			'is_safe' => ['html'],
		]));
	}

}