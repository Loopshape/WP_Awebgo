<?php // (C) Copyright Bobbing Wide 2013-2015

/**
 * Validate the language for GeSHi
 *
 * Note: html5 is a special version which will also remove unwanted tags.
 * Use 'none' when you want the output to be displayed ASIS
 *
 * @param string $lang - the required languange ( case insensitive )
 * @param string $text - alternative parameter for language ( case sensitive )
 * @return string - the validated language, or null
 * 
 */
function oik_css_validate_lang( $lang, &$text ) {
  //bw_trace2();
  $lang = strtolower( $lang );
  $valid = bw_assoc( bw_as_array( "css,html,javascript,jquery,php,html5,none" ));
  $vlang = bw_array_get( $valid, $lang, null );
  if ( !$vlang ) {
    $vlang = bw_array_get( $valid, $text, null );
    if ( $vlang ) {
      $text = $lang; 
    }  
  }
  if ( !$vlang ) {
    p( "Invalid lang= parameter for bw_geshi shortcode. $lang" );
    p( "$vlang,$text" );
  } 
  return( $vlang );
}

/**
 * Format the content for the chosen language
 *
 * @param array $atts - array of parameters. The formal parameter name is "text" but ANY value will do the job
 * @param string $content - the CSS to be displayed
 */
function bw_format_content( $atts, $content ) {
  $lang = bw_array_get_from( $atts, "lang,0", null );
  $text = bw_array_get_from( $atts, "text,1", null );
  $lang = oik_css_validate_lang( $lang, $text );
  if ( $lang ) {
    if ( $lang <> "html"  || $lang <> "none" ) {
      $content = bw_remove_unwanted_tags( $content );
    } else {
      $lang = "html5"; 
      //bw_trace2( $content, "html5-content" );
    } 
    sdiv( "bw_geshi $lang" );
    if ( $text <> "." ) {
      e( $text );
    }
    e( bw_geshi_it( $content, $lang ) );
    ediv();
  }
}

/**
 * Implement the [bw_geshi] shortcode for source code syntax highlighting
 *
 * @param array $atts shortcode parameters
 * @param string $content code to syntax highlight
 * @param string $tag
 * @return string syntax highlighted content
 */
function oik_geshi( $atts=null, $content=null, $tag=null ) {
  //bw_backtrace();
  //bw_trace2( $content, "pre fiddled content" );
  if ( $content ) {
    oik_require( "shortcodes/oik-css.php", "oik-css" );
    bw_format_content( $atts, $content );
  }
	$ret = bw_ret();
	//bw_trace2( $ret, "returning", false );
  return( $ret );
}

/** 
 * Help hook for the bw_geshi shortcode
 */ 
function bw_geshi__help( $shortcode="bw_geshi" ) {
  return( "Generic Syntax Highlighting" );
}

/**
 * Syntax hook for the bw_geshi shortcode
 *
 * Added "content" for shortcode UI
 * Removed "content" for shortcode UI - since it now uses "inner_content"
 * Added "none" language for no GeSHi processing
 */
function bw_geshi__syntax( $shortcode="bw_geshi" ) {
  $syntax = array( "lang" => bw_skv( null, "html|css|javascript|jquery|php|none", "Programming language" )
                 , "text" => bw_skv( null, "<i>text</i>", "Descriptive text to display" )
                 //, "content" => bw_skv( null, "textarea", "Content" )
                 );
  return( $syntax );
}

/**
 * Implement example hook for the bw_geshi shortcode
 * 
 * We can't use bw_invoke_shortcode() since we need to call esc_html() against the sample HTML code
 * otherwise it just gets processed as normal output
 *
 * @param string $shortcode 
 */
function bw_geshi__example( $shortcode="bw_css" ) {
  $text = "Demonstrating the HTML to create a link to www.oik-plugins.com";
  p( $text );
  $example = "[$shortcode";
  $example .= ' html .]<a href="http://www.oik-plugins.com">Visit oik-plugins.com</a>[/bw_geshi';
  $example .= ']';
  sp();
  stag( "code" );
  e( esc_html( $example ) ); 
  etag( "code" ); 
  ep();
  $expanded = apply_filters( 'the_content', $example );
  e( $expanded );
}




  


