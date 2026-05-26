<?php

namespace hypeJunction\Twig;

use Elgg\Hook;
use Elgg\ViewsService;
use Psr\Log\LogLevel;

/**
 * RenderTwigTemplate class.
 */
class RenderTwigTemplate {

	/**
	 * __invoke.
	 *
	 * @param Hook $hook hook
	 *
	 * @return mixed
	 */
	public function __invoke(Hook $hook) {

		$view = $hook->getParam('view');

		if (substr($view, -5) !== '.twig') {
			return null;
		}

		$vars = $hook->getValue();

		$template = substr($view, 0, -5);

		try {
			$output = Twig::instance()->render($template, $vars);
		} catch (\Exception $ex) {
			\elgg_log($ex, LogLevel::ERROR);
			return null;
		}

		$vars[ViewsService::OUTPUT_KEY] = $output;
		return $vars;
	}
}
