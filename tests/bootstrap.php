<?php
/**
 * PHPUnit bootstrap for hypetwig plugin tests.
 * Plugin must be installed at {elgg_root}/mod/hypetwig/
 */

// tests/ -> mod/hypetwig/ -> mod/ -> elgg_root/
$elggRoot = dirname(__DIR__, 3);

require_once $elggRoot . '/vendor/autoload.php';

// Load plugin vendor (Twig 3.x, etc.)
$pluginRoot = dirname(__DIR__);
if (file_exists($pluginRoot . '/vendor/autoload.php')) {
    require_once $pluginRoot . '/vendor/autoload.php';
}

// Load Elgg test classes (UnitTestCase, etc.)
$testClassesDir = $elggRoot . '/vendor/elgg/elgg/engine/tests/classes';
spl_autoload_register(function ($class) use ($testClassesDir) {
    $file = $testClassesDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Plugin classes
spl_autoload_register(function ($class) use ($pluginRoot) {
    if (strncmp($class, 'hypeJunction\\Twig\\', 18) !== 0) {
        return;
    }
    $file = $pluginRoot . '/classes/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

\Elgg\Application::loadCore();
