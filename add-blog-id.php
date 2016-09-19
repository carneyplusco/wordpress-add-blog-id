<?php
/**
 * Plugin Name: Add Blog and User ID on Network
 * Plugin URI:  http://wpengineer.com/2188/view-blog-id-in-wordpress-multisite/
 * Description: View Blog and User ID in WordPress Multisite
 * Version:     1.0.0
 * Author:      Frank Bültge
 * Author URI:  http://bueltge.de
 * License:     GPLv3
 */

! defined( 'ABSPATH' ) and exit;

class fb_add_blog_id {
	
	public static function init() {
		
		$class = __CLASS__ ;
		if ( empty( $GLOBALS[ $class ] ) )
			$GLOBALS[ $class ] = new $class;
	}
	
	public function __construct() {
		
		// add blog id
		add_filter( 'wpmu_blogs_columns', array( $this, 'get_id' ) );
		add_action( 'manage_sites_custom_column', array( $this, 'get_blog_id' ), 10, 2 );
		
		// add user id
		add_filter( 'manage_users-network_columns', array( $this, 'get_id' ) );
		add_action( 'manage_users_custom_column', array( $this, 'get_user_id' ), 10, 3 );
		
		add_action( 'admin_print_styles-sites.php', array( $this, 'add_style' ) );
		add_action( 'admin_print_styles-users.php', array( $this, 'add_style' ) );
	}
	
	public function get_blog_id( $column_name, $blog_id ) {
		
		if ( 'object_id' === $column_name )
			echo (int) $blog_id;
		
		return $column_name;
	}
	
	public function get_user_id( $value, $column_name, $user_id ) {
		
		if ( 'object_id' === $column_name )
			echo (int) $user_id;
	}
	
	// Add in a column header
	public function get_id( $columns ) {
		
		$columns['object_id'] = __('ID');
		
		return $columns;
	}
	
	public function add_style() {
		
		echo '<style>#object_id { width:7%; }</style>';
	}
}
add_action( 'plugins_loaded', array( 'fb_add_blog_id', 'init' ) );
