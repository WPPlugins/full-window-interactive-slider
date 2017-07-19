<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Full_Window_Interactive_Slider
 * @subpackage Full_Window_Interactive_Slider/includes
 * @author     Your Name <email@example.com>
 */
class Full_Window_Interactive_Slider_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	    if (get_option('nt_fwms_version') != FWMS_HANDL_VERSION) {
		    //Upgrade logic here
		    global $wpdb;
		    $charset_collate = $wpdb->get_charset_collate();
		    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			    //Create the table for the images
			$table_name = $wpdb->prefix."nt_fwms_slides";
			$nt_fwms_db_version = '0.0.2';
			$inst_nt_fwms_db_version = get_option( "nt_fwms_db_version" );
			if ( $nt_fwms_db_version != $inst_nt_fwms_db_version or $inst_nt_fwms_db_version = '') {
			  $sql = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  name tinytext NOT NULL,
			  image text NOT NULL,
			  coords text NOT NULL,
			  PRIMARY KEY (id)
			  )". $charset_collate .";";
			  dbDelta( $sql );
			  //echo $wpdb->last_error;
			  if(!isset($inst_nt_fwms_db_version)){
			    add_option( 'nt_fwms_db_version', $nt_fwms_db_version );
			  }else{
			    update_option( "nt_fwms_db_version", $nt_fwms_db_version );
			  }
			}
		    //Create the table for the coordinates
			//Asigo el nombre de la tabla
			$table_name = $wpdb->prefix."nt_fwms_coordinates";
			//Consulto si la tabla existe	    
			$nt_fwms_coordinates_db_version = '0.0.1';
			$inst_nt_fwms_coordinates_db_version = get_option( "nt_fwms_coordinates_db_version" );
			if ( $nt_fwms_coordinates_db_version != $inst_nt_fwms_coordinates_db_version or $inst_nt_fwms_coordinates_db_version = '') {
			  //Si la tabla no existe la creo 
			  $sql = "CREATE TABLE $table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  nameitem tinytext NOT NULL,
			  coord text NOT NULL,
			  content text NOT NULL,
			  tipo text NOT NULL,
			  PRIMARY KEY (id)
			  )". $charset_collate .";";
			  dbDelta( $sql );
			  //echo $wpdb->last_error;
			  if(!isset($inst_nt_fwms_coordinates_db_version)){
			    add_option( 'nt_fwms_coordinates_db_version', $nt_fwms_coordinates_db_version );
			  }else{
			    update_option( "nt_fwms_coordinates_db_version", $nt_fwms_coordinates_db_version );
			  }
			}
		    // Then update the version value
		    update_option('nt_fwms_version', FWMS_HANDL_VERSION);
		}
	}

}
