<?php // (C) Copyright Bobbing Wide 2014,2015

/**
 * Return the default selector for the theme's background image
 * 
 * In the first prototype we were probably doing this all wrong...
 * 
 * By default, the [bw_background] shortcode now applies the background to the body
 * Using the selector parameter you can override where the background image is to be targeted
 * Note: Some themes display the featured image prominently so using it as a background may not look right at all
 *
 * Default selector       | Theme  | area selected
 * ---------------------- | ------ | -----------------
 * article .entry-content | Twenty Twelve | article content - not the title
 * article.art-article   | Artisteer 4.1 | article whole area
 * article.hentry .art-postcontent | Artisteer 4.1 | article content, not the title 
 * body | Genesis framework? | article content, not the title
 * 
 * @return string - the CSS selector to target
 *
 * @TODO This code is wrong - it only produces the right result for Artisteer 4.1 themes. Extend for other themes based on table above
 *
 */
function bw_default_selector_for_theme() {
  //$selector = apply_filters( "bw_default_selector_for_theme", "article .entry-content" );
  //$selector = apply_filters( "bw_default_selector_for_theme", "article.art-article" );
  //$selector = apply_filters( "bw_default_selector_for_theme", "article.hentry .art-postcontent" );
  $selector = apply_filters( "bw_default_selector_for_theme", "body" );
  return( $selector );
} 

/**
 * Implement [bw_background] shortcode
 *
 * Displays an attached media image as the background image for the article
 * 
 * Rather than displaying the image as a link we generate the CSS instead.
 * This is slightly easier than using custom CSS since the author doesn't have to find the full URL of the file manually.
 * 
 * @TODO - support multiple background images
 * @TODO - support identification of the actual image ID to display rather than the parent
 * 
 * So [bw_background] will be the equivalent of the first CSS specification below
 * 
 * [bw_css] 
 * article { background: url("http://rowlandscastlewebdesign.com/phphants/files/2013/11/How-is-it-done.jpg" ) no-repeat; 
 *  background-size: 100% auto; color: white; } 
 *  a.bw_tree { color: white;  text-shadow: 0 1px 2px #000;}
 * article h3 { padding-top: 16%; } 
 * [/bw_css]
 *
 *
 * @param array $atts - shortcode parameters
 * @param string $content - not expected
 * @param string $tag - the shortcode tag
 * @return string - generated HTML
 */
function bw_background( $atts=null, $content=null, $tag=null ) {
  $atts['post_type'] = bw_array_get( $atts, "post_type", "attachment" );
  $atts['post_mime_type'] = bw_array_get( $atts, 'post_mime_type', 'image' );
  $atts['id'] = bw_array_get_from( $atts, "id,0", null );
  if ( $atts['id'] === null ) {
    // Don't set the ID yet.. let get_thumbnail_src do it.
  }
  $atts['thumbnail'] = bw_array_get( $atts, "thumbnail", "full" );
  oik_require( "includes/bw_posts.inc" );
  $thumbnail = bw_get_thumbnail_size( $atts );
  //$posts = bw_get_posts();
  //foreach ( $posts as $post ) {
  bw_trace2( $thumbnail, "thumbnail" );
    list( $thumbnail, $width, $height ) = bw_get_thumbnail_src( $atts['id'], $thumbnail, $atts );
    if ( $thumbnail ) {
      $selector = bw_array_get_from( $atts, "selector,1", null );
      if ( !$selector ) {
        $selector = bw_default_selector_for_theme();
      } 
      stag( "style", null, null, kv( "type", "text/css" ) . kv( "media", "screen,print")  );
      $css = "$selector { background: url( \"$thumbnail\" ) no-repeat;  background-size: 100% auto; background-origin: padding-box; }";
      e( $css );
      etag( "style" );
      
    } else {
      p( "No thumbnail" );
    }
  //}
  return( bw_ret() );
}

/**
 * Help hook for [bw_background] shortcode
 */
function bw_background__help( $shortcode="bw_background" ) {
  return( "Use attached image as the background" );
}

/**
 * Syntax hook for [bw_background] shortcode
 */
function bw_background__syntax( $shortcode="bw_background" ) {
	$syntax = array( "id,0" => bw_skv( "current ID", "<i>ID</i>", "Post ID to find image to display" )
						, "selector,1" => bw_skv( "body", "<i>CSS selector</i>", "CSS selector for the background image" ) 
						, "thumbnail" => bw_skv( "full", "thumbnail|medium|large", "Image size to use" )
						, "post_type" => bw_skv( "attachment", "<i>post type</i>", "Post type" )
						, "post_mime_type" => bw_skv( "image", "<i>post mime type</i>", "Post mime type" )
						);
	return( $syntax );
}
 
 
  
