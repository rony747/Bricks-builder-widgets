<?php
// rating-widget.php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class Touhid_Bricks_Rating_Widget extends \Bricks\Element {
	public $category     = 'general';
	public $name         = 'touhid_bricks_rating-widget';
	public $icon         = 'ti-star';
	public $css_selector = '.touhid_bricks_rating-widget';

	public function get_label() {
		return esc_html__( 'Rating Widget', 'touhid_bricks' );
	}

	public function set_controls() {
		$this->controls['touhid_bricks_ratingScale'] = [
			'tab' => 'content',
			'label' => esc_html__('Rating Scale', 'touhid_bricks'),
			'type' => 'number',
			'min' => 1,
			'max' => 10,
			'default' => 5,
		];

		$this->controls['touhid_bricks_rating'] = [
			'tab' => 'content',
			'label' => esc_html__('Rating', 'touhid_bricks'),
			'type' => 'number',
			'min' => 0,
			'max' => 10,
			'step' => 0.5,
			'default' => 0,
		];

		$this->controls['touhid_bricks_markedIcon'] = [
			'tab' => 'content',
			'label' => esc_html__('Marked Icon', 'touhid_bricks'),
			'type' => 'icon',
			'default' => [
				'library' => 'fontawesome',
				'icon' => 'fas fa-star',
			],
		];

		$this->controls['touhid_bricks_halfMarkedIcon'] = [
			'tab' => 'content',
			'label' => esc_html__('Half Marked Icon', 'touhid_bricks'),
			'type' => 'icon',
			'default' => [
				'library' => 'fontawesome',
				'icon' => 'fas fa-star-half-alt',
			],
		];

		$this->controls['touhid_bricks_unmarkedIcon'] = [
			'tab' => 'content',
			'label' => esc_html__('Unmarked Icon', 'touhid_bricks'),
			'type' => 'icon',
			'default' => [
				'library' => 'fontawesome',
				'icon' => 'far fa-star',
			],
		];

		$this->controls['touhid_bricks_iconSize'] = [
			'tab' => 'content',
			'label' => esc_html__('Icon Size', 'touhid_bricks'),
			'type' => 'number',
			'units' => true,
			'default' => '24px',
		];

		$this->controls['touhid_bricks_iconSpacing'] = [
			'tab' => 'content',
			'label' => esc_html__('Icon Spacing', 'touhid_bricks'),
			'type' => 'number',
			'units' => true,
			'default' => '5px',
		];

		$this->controls['touhid_bricks_markedColor'] = [
			'tab' => 'content',
			'label' => esc_html__('Marked Color', 'touhid_bricks'),
			'type' => 'color',
			'default' => [
				'hex' => '#ffd700',
			],
		];

		$this->controls['touhid_bricks_unmarkedColor'] = [
			'tab' => 'content',
			'label' => esc_html__('Unmarked Color', 'touhid_bricks'),
			'type' => 'color',
			'default' => [
				'hex' => '#cccccc',
			],
		];
	}

	public function render() {

		$settings = $this->settings;
		$ratingScale = isset($settings['touhid_bricks_ratingScale']) ? intval($settings['touhid_bricks_ratingScale']) : 5;
		$rating = isset($settings['touhid_bricks_rating']) ? floatval($settings['touhid_bricks_rating']) : 0;
		$markedIcon = isset($settings['touhid_bricks_markedIcon']) ? $settings['touhid_bricks_markedIcon'] : ['library' => 'fontawesome', 'icon' => 'fas fa-star'];
		$halfMarkedIcon = isset($settings['touhid_bricks_halfMarkedIcon']) ? $settings['touhid_bricks_halfMarkedIcon'] : ['library' => 'fontawesome', 'icon' => 'fas fa-star-half-alt'];
		$unmarkedIcon = isset($settings['touhid_bricks_unmarkedIcon']) ? $settings['touhid_bricks_unmarkedIcon'] : ['library' => 'fontawesome', 'icon' => 'far fa-star'];
		$iconSize = isset($settings['touhid_bricks_iconSize']) ? $settings['touhid_bricks_iconSize'] : '24px';
		$iconSpacing = isset($settings['touhid_bricks_iconSpacing']) ? $settings['touhid_bricks_iconSpacing'] : '5px';
		$markedColor = isset($settings['touhid_bricks_markedColor']['hex']) ? $settings['touhid_bricks_markedColor']['hex'] : '#ffd700';
		$unmarkedColor = isset($settings['touhid_bricks_unmarkedColor']['hex']) ? $settings['touhid_bricks_unmarkedColor']['hex'] : '#cccccc';


		// Set element attributes
		$root_classes[] = 'touhid_bricks_rating-wrapper';

		if ( ! empty( $this->settings['type'] ) ) {
			$root_classes[] = "color-{$this->settings['type']}";
		}

		// Add 'class' attribute to element root tag
		$this->set_attribute( '_root', 'class', $root_classes );

		// Render element HTML
		// '_root' attribute is required since Bricks 1.4 (contains element ID, class, etc.)
		echo "<div {$this->render_attributes( '_root' )}>"; // Element root attributes
		$output = "<div class='touhid_bricks_rating-widget'>";
		$output .= "<div class='tb_rating-icons' style='display:flex; gap:{$iconSpacing}; font-size: {$iconSize};'>";

		for ($i = 1; $i <= $ratingScale; $i++) {
			if ($i <= floor($rating)) {
				$icon = $markedIcon;
				$class = 'marked';
				$style = 'color:'.$markedColor;
			} elseif ($i - 0.5 == $rating) {
				$icon = $halfMarkedIcon;
				$class = 'half-marked';
				$style = 'color:'.$markedColor;
			} else {
				$icon = $unmarkedIcon;
				$class = 'unmarked';
				$style = 'color:'.$unmarkedColor;
			}
			$output .= "<i class='tb_rating-icon {$icon['library']} {$icon['icon']} {$class}' style='{$style}'></i>";
		}

		$output .= "</div>";
		$output .= "</div>";

		echo $output;
		echo '</div>';



	}


}