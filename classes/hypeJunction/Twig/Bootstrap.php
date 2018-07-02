<?php

namespace hypeJunction\Twig;

use Elgg\Database\Annotations;
use Elgg\Event;
use Elgg\Includer;
use Elgg\PluginBootstrap;

class Bootstrap extends PluginBootstrap {

	/**
	 * Get plugin root
	 * @return string
	 */
	protected function getRoot() {
		return $this->plugin->getPath();
	}

	/**
	 * {@inheritdoc}
	 */
	public function load() {
		Includer::requireFileOnce($this->getRoot() . '/autoloader.php');
		Includer::requireFileOnce($this->getRoot() . '/lib/functions.php');
	}

	/**
	 * {@inheritdoc}
	 */
	public function boot() {
		elgg_register_event_handler('cache:flush', 'system', function() {
			$cache = elgg_get_data_path() . 'twig/';
			if (is_dir($cache)) {
				_elgg_rmdir($cache);
			}
		});
	}

	/**
	 * {@inheritdoc}
	 */
	public function init() {
		//elgg_register_plugin_hook_handler('view_vars', 'all', RenderTwigTemplate::class, 999);
	}

	/**
	 * {@inheritdoc}
	 */
	public function ready() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function shutdown() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function activate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function deactivate() {

	}

	/**
	 * {@inheritdoc}
	 */
	public function upgrade() {

	}

}