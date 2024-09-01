<?php
// rating-widget.php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
class ETouhid_Bricks_Pdf_Widget extends \Bricks\Element {
	public $category     = 'general';
	public $name         = 'touhid_bricks_pdf-viewer';
	public $icon         = 'ti-file';
	public $scripts = [
		'touhid_bricks_pdfViewer'
	];
	public $css_selector = '.touhid_bricks_pdf-viewer';

	public function get_label() {
		return esc_html__( 'PDF Viewer', 'touhid_bricks' );
	}

	public function set_controls() {
		$this -> controls[ 'touhid_bricks_pdfUrl' ] = [
			'tab'     => 'content',
			'label'   => esc_html__( 'PDF Url', 'touhid_bricks' ),
			'type' => 'text',
			'default' => '',
		];
		$this->controls['touhid_bricks_pdf_width'] = [
			'tab' => 'content',
			'label' => esc_html__( 'Container Width', 'touhid_bricks' ),
			'type' => 'number',
			'min' => 100,
			'step' => '1', // Default: 1
			'inline' => true,
			'default' => 500,
		];
		$this->controls['touhid_bricks_pdf_height'] = [
			'tab' => 'content',
			'label' => esc_html__( 'Container Height', 'touhid_bricks' ),
			'type' => 'number',
			'min' => 100,
			'step' => '1', // Default: 1
			'inline' => true,
			'default' => 500,
		];
	}

	public function enqueue_scripts() {
		wp_enqueue_script(
			'touhid_bricks_pdfjs',
			plugin_dir_url( __FILE__ ) . 'js/pdfViewer/pdf.min.js',
			[ 'jquery' ],
			'1.0',
			true
		);
		wp_enqueue_script(
			'touhid_bricks_pdfviewer-script',
			plugin_dir_url( __FILE__ ) . 'js/pdfViewer/pdfScripts.js',
			[ 'jquery' ],
			'1.0',
			true
		);

		wp_enqueue_style(
			'touhid_bricks_rating-widget-style',
			plugin_dir_url( __FILE__ ) . 'css/touhid_bricks-styles.css'
		);
	}

	public function render() {

		$settings = $this->settings;
		$pdfUrl = isset($settings['touhid_bricks_pdfUrl']) ? $settings['touhid_bricks_pdfUrl'] : '';
		$containerWidth = isset($settings['touhid_bricks_pdf_width']) ? $settings['touhid_bricks_pdf_width'] : '100%';
		$containerHeight = isset($settings['touhid_bricks_pdf_height']) ? $settings['touhid_bricks_pdf_height'] : '600px';

		$workerUrl = plugin_dir_url( __FILE__ ) . 'js/pdfViewer/pdf.worker.min.js';
		// Localize the script with new data
		wp_localize_script('touhid_bricks_pdfviewer-script', 'pdfViewerData', array( 'workerUrl' => $workerUrl
		));

		// Set element attributes
		$root_classes[] = 'touhid_bricks_pdf-viewer';

		if ( ! empty( $this->settings['type'] ) ) {
			$root_classes[] = "color-{$this->settings['type']}";
		}

		// Add 'class' attribute to element root tag
		$this->set_attribute( '_root', 'class', $root_classes );

		// Render element HTML
		// '_root' attribute is required since Bricks 1.4 (contains element ID, class, etc.)
		echo "<div {$this->render_attributes( '_root' )}>"; // Element root attributes

		$output = "<div class='pdf-viewer-container' >";
		$output .= "<canvas id='pdf-viewer' data-url={$pdfUrl} data-width={$containerWidth} data-height= {$containerHeight}></canvas>";
		$output .= "</div>";




		echo $output;
		echo '</div>';



	}


}