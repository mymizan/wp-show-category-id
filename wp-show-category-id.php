<?php
/**
 * Plugin Name: WP Show Category ID
 * Plugin URI: https://yakub.xyz
 * Description: A simple plugin to show category IDs for post categories and WooCommerce product caegories
 * Author: M Yakub Mizan
 * Version: 1.0.0
 * Author URI: https://yakub.xyz
 **/


define( 'WP_SHOW_CAT_IDS_NAME', 'WP Show Category ID' );
define( 'WP_SHOW_CAT_IDS_VERSION', '1.0.0' );

class WP_SHOW_CAT_IDS_MAIN {

	/**
	 * All our action hooks and filters here
	 * so that they are regiestered when the
	 * plugin is initiated.
	 */
	public function __construct() {
		add_filter( 'term_name', array( $this, 'show_category_id' ), 10, 1 );
	}

	public function show_category_id( $term_name ) {

		if ( $this->is_showing_category_list() ) { 
			$cat_id = $this->__get_term_id( $term_name );

			if ( $cat_id != 0 ) {
				return  $term_name . ' (ID: '. $cat_id . ') ';
			} else {
				return $term_name;
			}
		}

		return $term_name;
	}

	public function is_showing_category_list() {
		$screen = get_current_screen();

		if ( $screen->id == 'edit-product_cat' || $screen->id == 'edit-category' ) {
			return true;
		}

		return;
	}

	public function __get_term_id( $term_name ) {
		$screen = get_current_screen();

		if ( $screen->id == 'edit-category' ) {
			return get_cat_ID( $term_name );;
		}

		if ( $screen->id == 'edit-product_cat' ) {
			$_term =  get_term_by('name', $term_name , 'product_cat');

			if ( $_term ) {
				return $_term->term_id;
			}
		}
	}
}


new WP_SHOW_CAT_IDS_MAIN();
