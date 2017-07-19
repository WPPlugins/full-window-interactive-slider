<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/admin
 * @author     Your Name <email@example.com>
 */
class Full_Window_Interactive_Slider_Admin {
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
	 * @param      string    $full_window_interactive_slider       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $full_window_interactive_slider, $version ) {

		$this->full_window_interactive_slider = $full_window_interactive_slider;
// 		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->full_window_interactive_slider, plugin_dir_url( __FILE__ ) . 'css/full-window-interactive-slider-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->full_window_interactive_slider, plugin_dir_url( __FILE__ ) . 'js/full-window-interactive-slider-admin.js', '', $this->version+1, true);
		wp_localize_script( $this->full_window_interactive_slider, 'info', array('url' => FWMS_GST_HANDL_PLUGIN_URL, 'text' => array(
		  'texttitle' => __( 'Title (optional)', 'full-window-interactive-slider' ),
		  'textcontent' => __( 'Content (insert a full url with http if you want a direct link)', 'full-window-interactive-slider' ),
		  'textchangepin' => __( 'Change pin', 'full-window-interactive-slider' ),
		  'textdiscard' => __( 'Discard', 'full-window-interactive-slider' )
		  )
		) );
		
	}
	public function add_fwms_custom_menu() {
    	global $fwmb_list_options_screen;
	    //add an item to the menu
		add_menu_page('Full Window', 'Full Window', 'manage_options', 'main_menu', array( $this, 'nt_fwmb_list_images' ));
	    $fwmb_list_options_screen = add_submenu_page(
	    	'main_menu', 
	    	__('Image list','full-window-interactive-slider'), 
	    	__('Image list','full-window-interactive-slider'), 
	    	'manage_options', 
	    	'main_menu', 
	    	 array( $this, 'nt_fwmb_list_images' )
	    );
	    add_action("load-$fwmb_list_options_screen", array( $this, 'fwmb_list_options_screen' ));	

	    add_submenu_page(
	    	'main_menu', 
	    	__('Add or edit image','full-window-interactive-slider'), 
	    	__('Add image','full-window-interactive-slider'), 
	    	'manage_options', 
	    	'full-window-interactive-slider', 
	    	array( $this, 'nt_fwmb_images' )
	    );

	}
	public function nt_fwmb_list_images(){
		require_once( dirname(__file__).'/images-list.php' );
	}
	public function nt_fwmb_images(){
		require_once( dirname(__file__).'/add-image.php' );
	}

	public function fwmb_list_options_screen() {
		global $fwmb_list_options_screen;
		$screen = get_current_screen();
		// get out of here if we are not on our settings page
		if(!is_object($screen) || $screen->id != $fwmb_list_options_screen)
			return;
		$args = array(
			'label' => __('Images per page', 'full-window-interactive-slider'),
			'default' => 5,
			'option' => 'per_page'
		);
		add_screen_option( 'per_page', $args );
	}
	public function fwmb_list_options_screen_set_screen_option($status, $option, $value) {
		if ( 'per_page' == $option ) return $value;
		return $status; // or return false;
	}
}
