<?php

namespace hypeJunction\Twig;

use Elgg\Project\Paths;
use Elgg\UnitTestCase;
use Twig\Error\LoaderError;
use Twig\Source;

/**
 * @group Twig
 */
class ViewLoaderTest extends UnitTestCase {

	public function up() {
		$this->plugin = $this->startPlugin();

		$view_location = dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/';

		elgg_set_view_location('test.twig', $view_location);
	}

	public function down() {

	}

	public function testCanNormalizeViewName() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$this->assertEquals('test.twig', $loader->normalizeViewName('test'));
		$this->assertEquals('test.twig', $loader->normalizeViewName('test.twig'));
	}

	public function testCanFindTemplate() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$expected = Paths::sanitize(dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/default/test.twig', false);

		$this->assertEquals($expected, $loader->findTemplate('test'));
		$this->assertEquals('', $loader->findTemplate('unknown'));
	}

	public function testCanGetSourceContext() {

		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$context = $loader->getSourceContext('test');

		$this->assertInstanceOf(Source::class, $context);
		$this->assertEquals('test', $context->getName());
		$this->assertEquals('Hello, {{ name }}', $context->getCode());
		$this->assertEquals(
			Paths::sanitize(dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/default/test.twig', false),
			Paths::sanitize($context->getPath(), false)
		);
	}

	/**
	 * @expectedException \Twig_Error_Loader
	 */
	public function testUnknownTemplateThrows() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$loader->getSourceContext('unknown');
	}

	public function testCanGetCacheKey() {

		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$path = Paths::sanitize(dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/default/test.twig', false);

		$this->assertEquals(sha1($path), $loader->getCacheKey('test'));
	}

	/**
	 * @expectedException \Twig_Error_Loader
	 */
	public function testUnknownTemplateThrowsWhenGettingCacheKey() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$loader->getCacheKey('unknown');
	}

	public function testCanCheckTemplateExistence() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$this->assertTrue($loader->exists('test'));
		$this->assertTrue($loader->exists('test.twig'));

		$this->assertFalse($loader->exists('unknown'));
		$this->assertFalse($loader->exists('unknown.twig'));
	}

	public function testCanCheckIfTemplateIsFresh() {

		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$path = Paths::sanitize(dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/default/test.twig', false);

		$mtime = filemtime($path);

		$this->assertFalse($loader->isFresh('test', $mtime - 1000));
		$this->assertTrue($loader->isFresh('test', $mtime + 1000));
	}

	/**
	 * @expectedException \Twig_Error_Loader
	 */
	public function testUnknownTemplateThrowsWhenCheckingFreshness() {
		$views = _elgg_services()->views;
		$loader = new ViewLoader($views);

		$loader->isFresh('unknown', time());
	}
}