<?php
/**
 * Plugin Name:     Rtl Categories
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     rtl-categories
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rtl_Categories
 */

if (!function_exists('is_plugin_active')) {
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if (is_plugin_active('elementor/elementor.php')) {
	function register_rtl_categories($widgets_manager): void
	{
		require_once(__DIR__ . '/widgets/elementor/rtl_categories.php');
		$widgets_manager->register(new RTL_Categories());
	}

	add_action('elementor/widgets/register', 'register_rtl_categories');

	function elementor_test_widgets_dependencies() {

		wp_register_script( 'rtl-categories-script-handle', plugins_url( 'assets/js/rtl_categories.js', __FILE__ ),array('jquery') );

		wp_register_style( 'rtl-categories-style-handle', plugins_url( 'assets/css/rtl_categories.css', __FILE__ ) );

		wp_localize_script( 'rtl-categories-script-handle', 'rtl_translations',
			array(
				'show_more_categories' => __('Show More Categories','rtl-categories'),
				'show_less_categories' => __('Show Less Categories','rtl-categories'),
			)
		);
	}
	add_action( 'wp_enqueue_scripts', 'elementor_test_widgets_dependencies' );

	function load_rtl_categorie_textdomain() {
		load_plugin_textdomain( 'rtl-categories', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	add_action( 'plugins_loaded', 'load_rtl_categorie_textdomain' );

} else {
	function send_notice_to_install_rtl_categories_plugin(): void
	{
		$plugin_file = plugin_basename(__FILE__);
		$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_file);
		$plugin_name = $plugin_data['Name'] ?? 'RTL Categories Plugin';

		if (!file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
			?>
			<div class="notice notice-error">
				<p><?php printf(__('%s requires <a href="%s">Elementor</a> plugin to be installed and activated.', 'rtl-categories'), $plugin_name, wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor')); ?></p>
			</div>
			<?php
		} else if (!is_plugin_active('elementor/elementor.php')) {
			?>
			<div class="notice notice-error">
				<p><?php printf(__('%s requires <a href="%s">Elementor</a> plugin to be activated.', 'rtl-categories'), $plugin_name, wp_nonce_url(admin_url('plugins.php?action=activate&plugin=elementor/elementor.php'), 'activate-plugin_elementor/elementor.php')); ?></p>
			</div>
			<?php
		}
	}

	add_action('admin_notices', 'send_notice_to_install_rtl_categories_plugin');
}
