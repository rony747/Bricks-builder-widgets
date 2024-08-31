<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tirony.me
 * @since      1.0.0
 *
 * @package    Touhid_bricks
 * @subpackage Touhid_bricks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Touhid_bricks
 * @subpackage Touhid_bricks/admin
 * @author     t. i. rony <touhid_rony@yahoo.com>
 */
class Touhid_bricks_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/touhid_bricks-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/touhid_bricks-admin.js', array( 'jquery' ), $this->version, false );

	}

public function check_bricks_theme_active() {
    $theme = wp_get_theme();

    if ($theme->get('Name') !== 'Bricks' && $theme->get('Template') !== 'bricks') {
      add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>Bricks Builder theme is required for this plugin to work.</p></div>';
      });

    }

  }
public function load_bricks_widgets() {
	$element_files = [
		__DIR__ . '/widgets/element-test.php',
	];

	foreach ( $element_files as $file ) {
		\Bricks\Elements::register_element( $file );
	}
  }
}
