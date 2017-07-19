<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/public
 * @author     Your Name <email@example.com>
 */
class Full_Window_Interactive_Slider_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $full_window_interactive_slider    The ID of this plugin.
	 */
	private $full_window_interactive_slider;

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
	 * @param      string    $full_window_interactive_slider       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $full_window_interactive_slider, $version ) {

		$this->full_window_interactive_slider = $full_window_interactive_slider;
		$this->version = $version;
		add_shortcode( 'nt_fwmb', array( $this, 'nt_fwmb_displayer' ) );	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Full_Window_Interactive_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Full_Window_Interactive_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
$post = get_post(get_the_ID()); 
		$content = $post->post_content; 
		if( has_shortcode( $content, 'nt_fwmb' ) ) {
		wp_enqueue_style( $this->full_window_interactive_slider, plugin_dir_url( __FILE__ ) . 'css/full-window-interactive-slider-public.css', array(), $this->version, 'all' );
	}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Full_Window_Interactive_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Full_Window_Interactive_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery.backstretch', plugin_dir_url( __FILE__ ) . 'js/jquery.backstretch.js', '', $this->version, true );
		wp_enqueue_script( $this->full_window_interactive_slider, plugin_dir_url( __FILE__ ) . 'js/full-window-interactive-slider-public.js', array( 'jquery.backstretch' ), $this->version, true );

	}
	/*The function to replace the template*/
	public function fwms_page_template( $page_template )
	{
		
		$post = get_post(get_the_ID()); 
		$content = $post->post_content; 
		if( has_shortcode( $content, 'nt_fwmb' ) ) {
		      // The content has a our shortcode, so this check returned true.
		      $page_template = FWMS_GST_HANDL_PLUGIN_DIR . '/templates/template-full-window.php';
		}
		return $page_template;
	}
	function nt_fwmb_displayer($atts) {
		$atts = shortcode_atts(
		array(
			'id' => array(),
		), $atts, 'nt_fwmb_displayer' );

		//require_once( FWMS_GST_HANDL_PLUGIN_DIR . 'public/partials/full-window-interactive-slider-public-display.php' );
		//Lo dejaste aqui, el tema es que el js tiene que venir antes que el script, pero el script necesita php... dramón.
		//$content = file_get_contents( FWMS_GST_HANDL_PLUGIN_DIR . 'public/partials/full-window-interactive-slider-public-display.php' );
		ob_start();
		include FWMS_GST_HANDL_PLUGIN_DIR . 'public/partials/full-window-interactive-slider-public-display.php';
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
