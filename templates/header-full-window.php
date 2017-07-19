<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arimo">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
	<?php wp_head(); ?>
	<link rel="shortcut icon" href="<?php echo site_url(); ?>/favicon.ico" />
	<style>
	#content.site-content{
	  padding: 0;
	  margin: 0;
	  width: 100%;
	}
	
	</style>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site" style="max-width: none;">



	<div id="content" class="site-content">
