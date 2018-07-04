<?php


namespace hypeJunction\Twig;

use Elgg\Project\Paths;
use Elgg\UnitTestCase;
use Faker\Generator;

/**
 * @group Twig
 */
class TwigTest extends UnitTestCase {

	/**
	 * @var Twig
	 */
	protected $twig;

	public function up() {
		$this->plugin = $this->startPlugin();

		$view_location = dirname(dirname(dirname(dirname(__FILE__)))) . '/test_files/views/default/';

		$views = _elgg_services()->views;

		$views->autoregisterViews('', $view_location, 'default');
		$views->autoregisterViews('', Paths::elgg() . '/views/default/', 'default');

		$loader = new ViewLoader($views);
		$twig = new Twig($loader);
		$twig->setup();

		$this->twig = $twig;
	}

	public function down() {

	}

	/**
	 * @dataProvider customFunctions
	 */
	public function testCustomFunctions($name, $callable) {
		$function = $this->twig->getFunction($name);
		$this->assertEquals($callable, $function->getCallable());
		$this->assertEquals($name, $function->getName());
	}

	public function customFunctions() {
		return [
			['echo', 'elgg_echo'],
			['view', 'elgg_view'],
			['assetUrl', 'elgg_get_simplecache_url'],
			['requireJs', 'elgg_require_js'],
			['formatHtml', 'elgg_format_html'],
			['menu', 'elgg_view_menu'],
		];
	}

	public function testGlobals() {
		$globals = $this->twig->getGlobals();

		$app = $globals['app'];
		/* @var $app \hypeJunction\Twig\App */

		$this->assertInstanceOf(App::class, $app);

		$this->assertEquals(elgg_get_logged_in_user_entity(), $app->user());
		$this->assertEquals(elgg_get_site_entity(), $app->site());
		$this->assertEquals(elgg_get_login_url(), $app->loginUrl());
		$this->assertEquals(elgg_get_registration_url(), $app->registrationUrl());

		$faker = $globals['faker'];
		/* @var $faker \hypeJunction\Twig\App */

		$this->assertInstanceOf(Generator::class, $faker);
	}

	public function testCanRenderTemplateWithAppGlobal() {
		$this->assertEquals(elgg_get_site_entity()->name, $this->twig->render('globals/app'));
	}

	public function testCanRenderTemplateWithFakerGlobal() {
		$this->assertNotEmpty($this->twig->render('globals/faker'));
	}

	public function testCanRenderTemplateWithEcho() {
		$this->assertEquals('hello', $this->twig->render('functions/echo'));
	}

	public function testCanRenderTemplateWithView() {
		$this->assertEquals('hello', $this->twig->render('functions/view'));
	}

	public function testCanRenderTemplateWithAssetUrl() {
		$this->assertEquals(elgg_get_simplecache_url('helpers/js'), $this->twig->render('functions/assetUrl'));
	}

	public function testCanRenderTemplateWithRequireJs() {
		$this->assertEquals('', $this->twig->render('functions/requireJs'));
		$this->assertContains('helpers/js', _elgg_services()->amdConfig->getDependencies());
	}

	public function testCanRenderTemplateWithFormatHtml() {
		$this->assertXmlStringEqualsXmlString('<p>hello</p>', $this->twig->render('functions/formatHtml'));
	}

	public function testCanRenderTemplateWithMenu() {
		elgg_register_menu_item('foo', [
			'name' => 'bar',
			'href' => 'bar',
			'text' => 'bar',
		]);

		$this->assertRegExp('/elgg-menu-item-bar/im', $this->twig->render('functions/menu'));
	}
}