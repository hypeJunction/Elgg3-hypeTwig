<?php

namespace hypeJunction\Twig;

use Elgg\Event;
use Elgg\ViewsService;
use Psr\Log\LogLevel;

/**
 * RenderTwigTemplate class.
 */
class RenderTwigTemplate {

	/**
	 * __invoke.
	 *
	 * @param Event $event event
	 *
	 * @return mixed
	 */
	public function __invoke(Event $event) {

		$view = $event->getParam('view');

		if (substr($view, -5) !== '.twig') {
			return null;
		}

		$vars = $event->getValue();

		$template = substr($view, 0, -5);

		try {
			$output = Twig::instance()->render($template, $vars);
		} catch (\Exception $ex) {
			elgg_log($ex, LogLevel::ERROR);
			return null;
		}

		$vars[ViewsService::OUTPUT_KEY] = $output;
		return $vars;
	}
}
