<?php

namespace hypeJunction\Twig;

class App {

	/**
	 * Get logged in user
	 * @return \ElggUser|null
	 */
	public function user() {
		return elgg_get_logged_in_user_entity();
	}

	/**
	 * Get site
	 * @return \ElggSite
	 */
	public function site() {
		return elgg_get_site_entity();
	}

	/**
	 * Get registration URL
	 * @return string
	 */
	public function registrationUrl() {
		return elgg_get_registration_url();
	}

	/**
	 * Get login URL
	 * @return string
	 */
	public function loginUrl() {
		return elgg_get_login_url();
	}
}