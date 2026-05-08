<a name="4.0.0"></a>
# 4.0.0 (2026-05-08)

### Breaking Changes

* **elgg:** raise minimum to Elgg 4.x (PHP 8.1+). Plugins on Elgg 3.x must stay on hypetwig 1.x.

### Migration (1.x → 4.x)

* **trait:** removed `Elgg\Di\ServiceFacade` usage; replaced with explicit `instance()` static method.
* **twig:** upgraded dependency to `twig/twig ^3.0` (Twig 3.x); updated `LoaderInterface` method signatures with PHP 8.0+ type hints.
* **tests:** updated `@expectedException \Twig_Error_Loader` annotations to `expectException(LoaderError::class)` (Twig 3.x class name).
* **docker:** stack updated to `php:8.1-apache`, `mysql:5.7`, `elgg/elgg 4.3.6`.

### Dependency Updates

* `elgg/elgg ^4.0`, PHP `>=8.1`, `twig/twig ^3.0`, version bumped to `4.0.0`

---

<a name="1.1.1"></a>
## [1.1.1](https://github.com/hypeJunctionPro/Elgg3-hypeTwig/compare/1.1.0...v1.1.1) (2018-07-07)


### Bug Fixes

* **data:** normalize entity exports when passing to templates ([07c5ff3](https://github.com/hypeJunctionPro/Elgg3-hypeTwig/commit/07c5ff3))



<a name="1.1.0"></a>
# [1.1.0](https://github.com/hypeJunctionPro/Elgg3-hypeTwig/compare/1.0.0...v1.1.0) (2018-07-04)


### Features

* **api:** add more functions and tests ([e2d9575](https://github.com/hypeJunctionPro/Elgg3-hypeTwig/commit/e2d9575))



<a name="1.0.0"></a>
# 1.0.0 (2018-07-02)


### Features

* **releases:** initial commit ([414763a](https://github.com/hypeJunctionPro/Elgg3-hypeTwig/commit/414763a))



