<?php
/**
Plugin Name: cookie-cat
Depends: oik base plugin
Plugin URI: http://www.oik-plugins.com/oik-plugins/cookie-cat
Description: [cookies] shortcode for producing a table of cookies the website uses
Version: 1.4
Author: bobbingwide
Author URI: http://www.oik-plugins.com/author/bobbingwide
License: GPL2

    Copyright 2012-2014 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

/**
 * Implement "oik_loaded" action for cookie-cat
 *
 * Note: We define the "cookies" filter here even though it's only invoked by cookie-cat
 * during the expansion of the [cookies] shortcode. 
 */
function cookie_cat_init() {
  add_filter( "cookies", "oik_cookie_filter", 11, 2 );
  add_action( "oik_admin_menu", "cookie_cat_admin_menu" );
}

/**
 * Implement "oik_add_shortcodes" action for cookie-cat
 */
function cookie_cat_oik_add_shortcodes() {
  bw_add_shortcode( 'cookies', 'cookie_cat',  oik_path( "shortcodes/cookie-cat.php", "cookie-cat"), false ); 
}

/*
 * Implement "admin_notices" action for cookie-cat 
 *  
 * Check plugin dependencies
 * This code will produce a message when cookie-cat is activated but oik isn't 
 * Now dependent upon oik v2.1
*/
function cookie_cat_activation() {
  static $plugin_basename = null;
  if ( !$plugin_basename ) {
    $plugin_basename = plugin_basename(__FILE__);
    add_action( "after_plugin_row_cookie-cat/cookie-cat.php" , "cookie_cat_activation" ); 
    if ( !function_exists( "oik_plugin_lazy_activation" ) ) { 
      require_once( "admin/oik-activation.php" );
    }  
  }  
  if ( is_multisite() ) { 
    $depends = "oik:2.2"; 
  } else {
    $depends = "oik:2.2";
  }     
  oik_plugin_lazy_activation( __FILE__, $depends, "oik_plugin_plugin_inactive" );
}

/**
 * Implement "oik_admin_menu" for cookie-cat
 */
function cookie_cat_admin_menu() {
  oik_require( "admin/cookie-cat.php", "cookie-cat" );
  cookie_cat_lazy_admin_menu( __FILE__ );
}

/**
 * Implement "cookies" filter for cookie-cat
 *
 * @param string $cookie_list
 * @return string 
 */   
function oik_cookie_filter( $cookie_list ) {
  oik_require( "shortcodes/cookie-cat.php", "cookie-cat" );
  return( oik_lazy_cookie_filter( $cookie_list ));  
}

/**
 * function to invoke when cookie-cat is loaded
 */
function cookie_cat_loaded() {
  add_action( "oik_loaded", "cookie_cat_init" );
  add_action( "oik_add_shortcodes", "cookie_cat_oik_add_shortcodes" );
  add_action( "admin_notices", "cookie_cat_activation" );
}

cookie_cat_loaded();






