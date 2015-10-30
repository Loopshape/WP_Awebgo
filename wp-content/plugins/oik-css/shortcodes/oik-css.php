 <?php // (C) Copyright Bobbing Wide 2013, 2014
/**
 * Enqueue the internal CSS styling
 *
 * This code COULD be improved to accumulate ALL the appended CSS into one block and then produced during footer processing.
 * Note: we also support media="print"
 *
 * @param array $atts - shortcode parameters - currently unused
 * @param string $content - the CSS to enqueue
 */
function bw_enqueue_style( $atts, $content ) {
  stag( "style", null, null, kv( "type", "text/css" ) . kv( "media", "screen,print")  );
  e( $content );
  etag( "style" );
}

/**
 * Format the CSS as part of the content, if required
 * 
 * @param array $atts - array of parameters. The formal parameter name is "text" but ANY value will do the job
 * @param string $content - the CSS to be displayed
 */
function bw_format_style( $atts, $content ) {
  $text = bw_array_get_from( $atts, "text,0", null );
  if ( $text ) {
    sdiv( "bw_css" ); 
    if ( $text <> "." ) {
      e( $text );
    }
    e( bw_geshi_it( $content ) );
    ediv();
  }
}

/**
 * Perform GeSHi - Generic Syntax Highlighter processing
 * 
 * If geshi_highlight() is already available then we don't need to load our version
 *
 * After highlighting convert any remaining '[' to &#091; to stop plugins such as NextGen from expanding the shortcodes.
 * Note: It shouldn't matter if we do this to CSS 
 * 
 * @param string $content - the code to be put through GESHI highlighting
 * @param string $language - the language to use.
 * @return string the highlighted code
 */
function bw_geshi_it( $content, $language="CSS" ) {
	
	if ( $language != "none" ) {
		if ( !function_exists('geshi_highlight') ) {
			oik_require( "geshi/geshi.php", "oik-css" );
		}
		$geshid = geshi_highlight( $content, $language, null, true );
	} else {
		$content = esc_html( $content );
		$geshid = "<pre>" . $content . "</pre>";
	}
	bw_trace2( $geshid );
	$geshid = str_replace( "[", "&#091;", $geshid );
	return( $geshid );
}

/**
 * Remove unwanted tags introduced by other filters
 * 
 * The $content may contain all sorts of nastys that WordPress filters have added to the plain text so we need to strip it out.
 * @link http://www.ascii.cl/htmlcodes.htm
 *
 * @param string $content 
 * @return string - content with the unwanted HTML removed
 */ 
function bw_remove_unwanted_tags( $content ) {
  $dec = $content;
  $dec = str_replace( "<br />", "", $dec );
  $dec = str_replace( "<p>", "", $dec );
  $dec = str_replace( "</p>", "", $dec );
  
  $dec = str_replace( "&#8216;", "'", $dec );  // Left single quotation mark
  $dec = str_replace( "&#8217;", "'", $dec );  // Right single quotation mark
  $dec = str_replace( "&#8220;", '"', $dec );  // Left double quotation mark
  $dec = str_replace( "&#8221;", '"', $dec );  // Right double quotation mark
  $dec = str_replace( "&#038;", '&', $dec );   // Ampersand
  $dec = str_replace( "&#8211;", "-", $dec );  // en dash
  //bw_trace2( $dec, "de-tagged content" );
  return( $dec );
}

/**
 * Implement [bw_css] shortcode
 * 
 * @param array $atts - array of shortcode parameters
 * @param string $content - the CSS to be put into the page
 * @param string $tag - the shortcode tag - not expected
 * @return string any text to be put onto the page
 * 
 */
function oik_css( $atts=null, $content=null, $tag=null ) {
  if ( $content ) {
    $content = bw_remove_unwanted_tags( $content );
    bw_enqueue_style( $atts, $content );
    bw_format_style( $atts, $content );
  }
  return( bw_ret() );
}

function bw_css__help( $shortcode="bw_css" ) {
  return( __( "Add internal CSS styling", "oik-css" ) );
}

/**
 * Implement syntax hook for the bw_css shortcode
 *
 * The shortcode is expected to be coded as 
 * [bw_css]<i>Internal CSS rules</i>[/bw_css]
 *
 * If you want the CSS to be passed through GeSHi and output to the page then this is indicated using a parameter.
 * A simple . will cause the CSS to be echoed 
 * Anything other than .  which could be as text="echo this text" or just "echo this text" will be echoed before the CSS 
 */
function bw_css__syntax( $shortcode="bw_css" ) {
  $syntax = array( "." => bw_skv( null, "<i>any</i>", "Display the CSS" )
                 , "text" => bw_skv( null, "<i>any</i>", "Display the CSS with this annotation" )
                 );
  return( $syntax );
}

/**
 * Implement example hook for the bw_css shortcode
 */
function bw_css__example( $shortcode="bw_css" ) {
  $text = "When the &lt;code&gt; tag follows a &lt;p&gt; tag use a 14px font and different colours";
  $example = " ] p> code { font-size: 14px; color: white; background: #333; }[/bw_css";
  bw_invoke_shortcode( $shortcode, $example, $text );
  $text = "Elsewhere display &lt;code&gt; in blue.";
  $example = " ]code { color: blue; } [/bw_css";
  bw_invoke_shortcode( $shortcode, $example, $text );
  $text = "Use a parameter to cause the CSS to be shown.";
  $example = " .] td code b { color: darkblue; } [/bw_css";
  bw_invoke_shortcode( $shortcode, $example, $text );
}




  
  


