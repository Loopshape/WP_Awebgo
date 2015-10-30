<?php // (C) Copyright Bobbing Wide 2014

function oik_css_lazy_oik_menu_box() {
  oik_box( null, null, "oik-CSS options", "oik_css_options" );
}

function oik_css_options() {
  $option = "bw_css_options";
  $options = bw_form_start( $option, "oik_css_options" );
  
  bw_checkbox_arr( $option, "Disable automatic paragraph creation", $options, "bw_autop" ); 
 
  etag( "table" ); 			
  //bw_tablerow( array( "", "<input type=\"submit\" name=\"ok\" value=\"Save changes\" class=\"button-primary\"/>") ); 
  e( isubmit( "ok", __("Save changes", "oik" ), null, "button-secondary" ) ); 
  etag( "form" );
  //$bw_autop = $options['bw_autop'] ;
  //if ( $bw_autop ) {
    p( "To enable automatic paragraph creation use the [bw_autop] shortcode." );
  //} else {
    p( "To disable automatic paragraph creation use [bw_autop off]." );
  //
  bw_flush();
}
