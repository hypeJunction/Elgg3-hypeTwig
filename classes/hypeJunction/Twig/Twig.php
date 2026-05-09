<?php

namespace hypeJunction\Twig;

use Faker\Factory;
use Twig\Environment;
use Twig\TwigFunction;

/**
 * Twig class.
 */
class Twig extends Environment {

	/**
	 * Return the service instance from the DI container.
	 *
	 * @return self
	 */
	public static function instance(): self {
		return elgg()->get('twig');
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

		$this->addFunction(new TwigFunction('importEsm', 'elgg_import_esm'));

		$this->addFunction(new TwigFunction('formatHtml', 'elgg_format_html', [
			'pre_escape' => 'html',
			'is_safe' => ['html'],
		]));

		$this->addFunction(new TwigFunction('menu', 'elgg_view_menu', [
			'pre_escape' => 'html',
			'is_safe' => ['html'],
		]));
	}

	/**
	 * Normalize variables
	 *
	 * @param array $vars Vars
	 * @return array
	 */
	public function normalizeVars(array $vars = []) {
		foreach ($vars as &$value) {
			if (is_array($value)) {
				$value = $this->normalizeVars($value);
			} else if ($value instanceof \ElggEntity) {
				$value = $value->toObject();
			}
		}

		return $vars;
	}
}
