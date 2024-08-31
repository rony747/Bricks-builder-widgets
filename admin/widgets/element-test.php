<?php
// element-test.php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class Element_Rating_Widget extends \Bricks\Element {
	public $category     = 'general';
	public $name         = 'rating-widget';
	public $icon         = 'ti-star';
	public $css_selector = '.rating-widget';

	public function get_label() {
		return esc_html__( 'Rating Widget', 'touhid_bricks' );
	}

	public function set_controls() {
		$this -> controls[ 'ratingScale' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Rating Scale', 'touhid_bricks' ),
			'type'    => 'number',
			'min'     => 1,
			'max'     => 10,
			'default' => 5,
		];
		$this -> controls[ 'rating' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Rating', 'touhid_bricks' ),
			'type'    => 'number',
			'min'     => 0,
			'max'     => 10,
			'step'    => 0.1,
			'default' => 0,
		];
		$this -> controls[ 'placeholderIcon' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Placeholder Icon', 'touhid_bricks' ),
			'type'    => 'icon',
			'default' => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-star',
			],
		];
		$this -> controls[ 'markedIcon' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Marked Icon', 'touhid_bricks' ),
			'type'    => 'icon',
			'default' => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-star',
			],
		];
		$this -> controls[ 'unmarkedIcon' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Unmarked Icon', 'touhid_bricks' ),
			'type'    => 'icon',
			'default' => [
				'library' => 'far fa-star',
				'icon'    => 'far fa-star',
			],
		];
		$this -> controls[ 'iconSize' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Icon Size', 'touhid_bricks' ),
			'type'    => 'number',
			'units'   => true,
			'default' => '24px',
		];
		$this -> controls[ 'iconSpacing' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'Icon Spacing', 'touhid_bricks' ),
			'type'    => 'number',
			'units'   => true,
			'default' => '5px',
		];
	}
	public function enqueue_scripts() {
		wp_enqueue_script(
			'rating-widget-script',
			plugin_dir_url( __FILE__ ) . 'js/touhid_bricks-rating.js',
			[ 'jquery' ],
			'1.0',
			true
		);
		wp_enqueue_style(
			'rating-widget-style',
			plugin_dir_url( __FILE__ ) . 'css/touhid_bricks-rating.css'
		);
	}

	public function render() {

		$settings = $this->settings;
		$ratingScale = isset($settings['ratingScale']) ? intval($settings['ratingScale']) : 5;
		$rating = isset($settings['rating']) ? floatval($settings['rating']) : 0;
		$markedIcon = isset($settings['markedIcon']) ? $settings['markedIcon'] : ['library' => 'fontawesome', 'icon' => 'fas fa-star'];
		$unmarkedIcon = isset($settings['unmarkedIcon']) ? $settings['unmarkedIcon'] : ['library' => 'fontawesome', 'icon' => 'far fa-star'];
		$iconSize = isset($settings['iconSize']) ? $settings['iconSize'] : '24px';
		$iconSpacing = isset($settings['iconSpacing']) ? $settings['iconSpacing'] : '5px';
		$markedColor = isset($settings['markedColor']['hex']) ? $settings['markedColor']['hex'] : '#ffd700';
		$unmarkedColor = isset($settings['unmarkedColor']['hex']) ? $settings['unmarkedColor']['hex'] : '#cccccc';

		// Set element attributes
		$root_classes[] = 'prefix-test-wrapper';

		if ( ! empty( $this->settings['type'] ) ) {
			$root_classes[] = "color-{$this->settings['type']}";
		}

		// Add 'class' attribute to element root tag
		$this->set_attribute( '_root', 'class', $root_classes );

		// Render element HTML
		// '_root' attribute is required since Bricks 1.4 (contains element ID, class, etc.)
		echo "<div {$this->render_attributes( '_root' )}>"; // Element root attributes
		$output = "<div class='rating-widget' style='--icon-size: {$iconSize}; --icon-spacing: {$iconSpacing}; --marked-color: {$markedColor}; --unmarked-color: {$unmarkedColor};'>";
		$output .= "<div class='rating-icons'>";

		for ($i = 1; $i <= $ratingScale; $i++) {
			if ($i <= floor($rating)) {
				$icon = $markedIcon;
				$class = 'marked';
			} elseif ($i == ceil($rating) && $rating != floor($rating)) {
				$icon = $markedIcon;
				$class = 'partial';
				$percentage = ($rating - floor($rating)) * 100;
			} else {
				$icon = $unmarkedIcon;
				$class = 'unmarked';
			}

			$output .= "<i class='rating-icon {$icon['library']} {$icon['icon']} {$class}'";
			if (isset($percentage)) {
				$output .= " style='--partial-value: {$percentage}%'";
			}
			$output .= "></i>";
		}

		$output .= "</div>";
		$output .= "</div>";

		echo $output;
		echo '</div>';



	}


}