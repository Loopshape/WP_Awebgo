<?php // (C) Copyright Bobbing Wide 2015

/**
 * WordPress API for processing shortcodes earlier - before other filter processing
 * 
 * Shortcodes are expected to be coded in the same format as documented in shortcodes.php
 * The reason we want to expand shortcodes earlier is to extract content from the database
 * and generate the HTML using the written content, then apply the texturizing logic later.
 * 
 * The texturizing will have to respect the requests of the shortcodes to not texturize their output.
 * This is achieved by HTML comments generated in the ouptut.
 * - `<!--notext:-->` represents the start of the content that should not be texturized
 * - `<!--dotext:-->` represents the end of the content that should not be texturized
 * 
 * There should be no reason to support nested notext: comments
 * The code does not yet prevent this from happening. 
 * 
 * Note: notext: and dotext: are arbitrarily chosen keywords that have not yet been used.
 * Abbreviations for "no texturize" and "do texturize"
 * 
 * We didn't use `<!--/notext-->` since this seems too clumsy
 *
 * To apply shortcode tags to content which may generate notext:/dotext: comments:
 * `
 * $out = do_shortcode_earlier( $content );
 * `
 * 
 * You also need to replace: 
 * `
 * add_filter('the_content', 'do_shortcode', 11); // AFTER wpautop()
 * `
 *
 * with:
 * `
 * remove_filter( 'the_content', 'do_shortcode', 11 ); 
 * add_filter( 'the_content', 'do_shortcode_earlier', 10 ); // BEFORE wpautop();
 * `
 * 
 * alternatively use:
 * `
 * bw_replace_filter( 'the_content', 'do_shortcode', 11, 'do_shortcode_earlier' );
 * `
 * where bw_replace_filter() is from the oik base plugin.
 * 
 *
 *
 * @link http://codex.wordpress.org/Shortcode_API
 *
 * @package WordPress
 * @subpackage Shortcodes
 * @since 4.x 
 */
 
 

/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 *
 * @since 4.2
 *
 * @uses $shortcode_tags
 *
 * @param string $content Content to search for shortcodes
 * @return string Content with shortcodes expanded
 */
if ( !function_exists( "do_shortcode_earlier" ) ) { 
function do_shortcode_earlier($content) {
	global $shortcode_tags;

	if ( false === strpos( $content, '[' ) ) {
		return $content;
	}

	if (empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = get_shortcode_regex();
	return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag_earlier', $content );
}
}

/**
 * Regular Expression callable for do_shortcode_earlier() for calling shortcode hook.
 * 
 * @see get_shortcode_regex for details of the match array contents.
 *
 * @since 4.2
 * @access private
 * @uses $shortcode_tags
 *
 * @param array $m Regular expression match array
 * @return mixed False on failure.
 */
if ( !function_exists( "do_shortcode_tag_earlier" ) ) {
function do_shortcode_tag_earlier( $m ) {
  $return = do_shortcode_tag( $m );
  $tag = $m[2];
  $shortcodes = apply_filters( "no_texturize_shortcodes", array() );
  if ( count( $shortcodes ) && in_array( $tag, $shortcodes ) ) { 
    $return = notext_wrappit( $return ); 
  }
  return( $return );
}
}

/**
 * Wrap the result of the shortcode in notext/dotext
 *
 * @param string $return expanded shortcode
 * @return string the expanded shortcode wrapped in notext/dotext HTML comments
 */
if ( !function_exists( "notext_wrappit" ) ) {
function notext_wrappit( $return ) {
  $wrapped = "<!--notext:-->";
  $wrapped .= $return;
  $wrapped .= "<!--dotext:-->";
  return( $wrapped ); 
}
}



