<?php

namespace hypeJunction\Twig;

use Elgg\Project\Paths;
use Elgg\ViewsService;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class ViewLoader implements LoaderInterface {

	protected $views;

	/**
	 * Constructor
	 *
	 * @param ViewsService $views Views service
	 */
	public function __construct(ViewsService $views) {
		$this->views = $views;
	}

	/**
	 * Add twig extension to view name
	 *
	 * @param string $name View name
	 * @return string
	 */
	public function normalizeViewName($name) {
		if (substr($name, -5) !== '.twig') {
			$name = "$name.twig";
		}

		return $name;
	}

	/**
	 * Find twig template location
	 *
	 * @param string $name Name
	 *
	 * @return string
	 */
	public function findTemplate($name) {
		$view_name = $this->normalizeViewName($name);

		$path = $this->views->findViewFile($view_name, 'default');
		if ($path) {
			return Paths::sanitize($path, false);
		}

		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSourceContext($name) {
		$view_name = $this->normalizeViewName($name);
		$path = $this->findTemplate($name);

		if (!$path) {
			throw new LoaderError("''$view_name' view does not exist");
		}

		$source = file_get_contents($path);

		return new Source($source, $name, $path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCacheKey($name) {
		$path = $this->findTemplate($name);
		if (!$path) {
			throw new LoaderError("''$name' template does not exist");
		}

		return sha1($path);
	}

	/**
	 * {@inheritdoc}
	 */
	public function isFresh($name, $time) {
		$path = $this->findTemplate($name);

		if (!$path) {
			throw new LoaderError("''$name' template does not exist");
		}

		return filemtime($path) <= $time;
	}

	/**
	 * {@inheritdoc}
	 */
	public function exists($name) {
		return (bool) $this->findTemplate($name);
	}
}