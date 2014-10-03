<?php
/**
 * @version    $Id$
 * @package    WR MegaMenu
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com
 */

/**
 * WR MegaMenu plugin initialization.
 *
 * @package  WR_Megamenu
 * @since	1.0.0
 */

class WR_Megamenu_Plugin {
	/**
	 * Initialize WR Sample plugin.
	 *
	 * @return  void
	 */
	public static function init() {
		global $wp_widget_factory, $mega_menu, $wr_megamenu_element, $wr_megamenu_widgets;

		// Init neccessary WR Library classes
		WR_Megamenu_Init_Admin_Menu::hook();
		// Load required assets
		WR_Megamenu_Assets::init();

		WR_Megamenu_Init_Assets	::hook();
		// Load update simulator
		WR_Megamenu_Update_Simulator::hook();

		// Init element
		$wr_megamenu_element = new WR_Megamenu_Element();
		$wr_megamenu_element->init();

		//
		if ( is_admin() ){
			$mega_menu = new WR_Megamenu_Core_Backend();
		} else {
			// Process menu frontend
			$frontend = new WR_Megamenu_Core_Frontend();
			$frontend->apply_megamenu();
		}

		// Register 'admin_menu' action
		//add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

		// Register 'wr_mm_installed_product' filter
		add_filter( 'wr_mm_installed_product', array( __CLASS__, 'register_product' ) );

		// Initialize widget support
		$wr_megamenu_widgets = ! empty( $wr_megamenu_widgets ) ? $wr_megamenu_widgets : WR_Megamenu_Helpers_Functions::widgets();


	}

	/**
	 * Do 'admin_menu' action.
	 *
	 * @return  void
	 */
	public static function admin_menu() {
		// Register admin menu
		WR_Megamenu_Admin_Menu::init();
	}

	/**
	 * Apply 'wr_mm_installed_product' filter.
	 *
	 * @param   array  $plugins  Array of installed WooRockets product.
	 *
	 * @return  array
	 */
	public static function register_product( $plugins ) {
		// Register product identification
		$plugins[] = WR_MEGAMENU_IDENTIFIED_NAME;

		return $plugins;
	}

}
