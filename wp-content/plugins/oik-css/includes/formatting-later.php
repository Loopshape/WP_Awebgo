<?php // (C) Copyright Bobbing Wide 2014-2015

/*
 * Allow for the autopia plugin 
 *
 *
 * - The autopia plugin is a (vapourware) "feature plugin"
 * - It contains code intended for the WordPress core
 * - If the current version of WordPress already provides the required function, or autopia is available then we'll use its logic otherwise we have to define it ourselves
 *
 * For the moment, in this simple version, we just perform function_exists() testing
 * implemented with belt and braces; around each function
 *
 */
 
/**
 * Apply wptexturize logic in blocks
 * 
 * The content has been expanded and we now have output that may contain:
 * - a load of stuff that can be texturized, 
 * - followed by some that can't 
 * - `<!--notext:-->` this is the text that can't, ending in `<!--dotext:-->`
 * - then more that can be texturized
 
 * Assume: We don't need to recursively process the <!--notext: <!--dotext: pairs
 * - Any routine that thinks it's necessary should add its own dotext: notext: pairing around stuff that can be texturized
 * - OR create texturized content in the first place
 * 
 * AND we hope wpautop() doesn't mess it up either
 * 
 * @since 4.2.0
 *
 * @param string $content the string to be texturized
 * @return string the texturized content without notext:/dotext: comments
 *
 */ 
if ( !function_exists( "wptexturize_blocks" ) ) { 
function wptexturize_blocks( $content ) {
  $result = null;
  $rest = $content;
  $spos = strpos( $rest, "<!--notext:-->" );
  while ( $spos != false ) {
    $left = substr( $rest, 0, $spos );
    $result .= wptexturize_after_shortcodes( $left );
    $right = substr( $rest, $spos+14 );
    $epos = strpos( $right, "<!--dotext:-->" );
    if ( $epos != false ) { 
      $result .= substr( $right, 0, $epos );
      $rest = substr( $right, $epos+14 );
    } else {
      // Not expected? 
      $result .= $right; 
      $rest = null;
    } 
    $spos = strpos( $rest, "<!--notext:-->" );
  }
  $result .= wptexturize_after_shortcodes( $rest );
  return( $result );
}
} /* endif exists wptexturize_blocks */

/**
 * Replaces common plain text characters into formatted entities
 *
 * As an example,
 *
 *     'cause today's effort makes it worth tomorrow's "holiday" ...
 *
 * Becomes:
 *
 *     &#8217;cause today&#8217;s effort makes it worth tomorrow&#8217;s &#8220;holiday&#8221; &#8230;
 *
 * Code within certain html blocks are skipped.
 *
 * @since 0.71
 * @uses $wp_cockneyreplace Array of formatted entities for certain common phrases
 *
 * @param string $text The text to be formatted
 * @param bool $reset Set to true for unit testing. Translated patterns will reset.
 * @return string The string replaced with html entities
 */
if ( !function_exists( "wptexturize_after_shortcodes" ) ) {
function wptexturize_after_shortcodes($text, $reset = false) {
	global $wp_cockneyreplace, $shortcode_tags;
	static $static_characters, $static_replacements, $dynamic_characters, $dynamic_replacements,
		$default_no_texturize_tags, $default_no_texturize_shortcodes, $run_texturize = true;

	// If there's nothing to do, just stop.
	if ( empty( $text ) || false === $run_texturize ) {
		return $text;
	}

	// Set up static variables. Run once only.
	if ( $reset || ! isset( $static_characters ) ) {
		/**
		 * Filter whether to skip running wptexturize().
		 *
		 * Passing false to the filter will effectively short-circuit wptexturize().
		 * returning the original text passed to the function instead.
		 *
		 * The filter runs only once, the first time wptexturize() is called.
		 *
		 * @since 4.0.0
		 *
		 * @see wptexturize()
		 *
		 * @param bool $run_texturize Whether to short-circuit wptexturize().
		 */
		$run_texturize = apply_filters( 'run_wptexturize', $run_texturize );
		if ( false === $run_texturize ) {
			return $text;
		}

		/* translators: opening curly double quote */
		$opening_quote = _x( '&#8220;', 'opening curly double quote' );
		/* translators: closing curly double quote */
		$closing_quote = _x( '&#8221;', 'closing curly double quote' );

		/* translators: apostrophe, for example in 'cause or can't */
		$apos = _x( '&#8217;', 'apostrophe' );

		/* translators: prime, for example in 9' (nine feet) */
		$prime = _x( '&#8242;', 'prime' );
		/* translators: double prime, for example in 9" (nine inches) */
		$double_prime = _x( '&#8243;', 'double prime' );

		/* translators: opening curly single quote */
		$opening_single_quote = _x( '&#8216;', 'opening curly single quote' );
		/* translators: closing curly single quote */
		$closing_single_quote = _x( '&#8217;', 'closing curly single quote' );

		/* translators: en dash */
		$en_dash = _x( '&#8211;', 'en dash' );
		/* translators: em dash */
		$em_dash = _x( '&#8212;', 'em dash' );

		$default_no_texturize_tags = array('pre', 'code', 'kbd', 'style', 'script', 'tt');
		$default_no_texturize_shortcodes = array('code');

		// if a plugin has provided an autocorrect array, use it
		if ( isset($wp_cockneyreplace) ) {
			$cockney = array_keys($wp_cockneyreplace);
			$cockneyreplace = array_values($wp_cockneyreplace);
		} elseif ( "'" != $apos ) { // Only bother if we're doing a replacement.
			$cockney = array( "'tain't", "'twere", "'twas", "'tis", "'twill", "'til", "'bout", "'nuff", "'round", "'cause" );
			$cockneyreplace = array( $apos . "tain" . $apos . "t", $apos . "twere", $apos . "twas", $apos . "tis", $apos . "twill", $apos . "til", $apos . "bout", $apos . "nuff", $apos . "round", $apos . "cause" );
		} else {
			$cockney = $cockneyreplace = array();
		}

		$static_characters = array_merge( array( '...', '``', '\'\'', ' (tm)' ), $cockney );
		$static_replacements = array_merge( array( '&#8230;', $opening_quote, $closing_quote, ' &#8482;' ), $cockneyreplace );


		// Pattern-based replacements of characters.
		// Sort the remaining patterns into several arrays for performance tuning.
		$dynamic_characters = array( 'apos' => array(), 'quote' => array(), 'dash' => array() );
		$dynamic_replacements = array( 'apos' => array(), 'quote' => array(), 'dash' => array() );
		$dynamic = array();
		$spaces = wp_spaces_regexp();

		// '99' and '99" are ambiguous among other patterns; assume it's an abbreviated year at the end of a quotation.
		if ( "'" !== $apos || "'" !== $closing_single_quote ) {
			$dynamic[ '/\'(\d\d)\'(?=\Z|[.,)}\-\]]|&gt;|' . $spaces . ')/' ] = $apos . '$1' . $closing_single_quote;
		}
		if ( "'" !== $apos || '"' !== $closing_quote ) {
			$dynamic[ '/\'(\d\d)"(?=\Z|[.,)}\-\]]|&gt;|' . $spaces . ')/' ] = $apos . '$1' . $closing_quote;
		}

		// '99 '99s '99's (apostrophe)  But never '9 or '99% or '999 or '99.0.
		if ( "'" !== $apos ) {
			$dynamic[ '/\'(?=\d\d(?:\Z|(?![%\d]|[.,]\d)))/' ] = $apos;
		}

		// Quoted Numbers like '0.42'
		if ( "'" !== $opening_single_quote && "'" !== $closing_single_quote ) {
			$dynamic[ '/(?<=\A|' . $spaces . ')\'(\d[.,\d]*)\'/' ] = $opening_single_quote . '$1' . $closing_single_quote;
		}

		// Single quote at start, or preceded by (, {, <, [, ", -, or spaces.
		if ( "'" !== $opening_single_quote ) {
			$dynamic[ '/(?<=\A|[([{"\-]|&lt;|' . $spaces . ')\'/' ] = $opening_single_quote;
		}

		// Apostrophe in a word.  No spaces, double apostrophes, or other punctuation.
		if ( "'" !== $apos ) {
			$dynamic[ '/(?<!' . $spaces . ')\'(?!\Z|[.,:;"\'(){}[\]\-]|&[lg]t;|' . $spaces . ')/' ] = $apos;
		}

		// 9' (prime)
		if ( "'" !== $prime ) {
			$dynamic[ '/(?<=\d)\'/' ] = $prime;
		}

		// Single quotes followed by spaces or ending punctuation.
		if ( "'" !== $closing_single_quote ) {
			$dynamic[ '/\'(?=\Z|[.,)}\-\]]|&gt;|' . $spaces . ')/' ] = $closing_single_quote;
		}

		$dynamic_characters['apos'] = array_keys( $dynamic );
		$dynamic_replacements['apos'] = array_values( $dynamic );
		$dynamic = array();

		// Quoted Numbers like "42"
		if ( '"' !== $opening_quote && '"' !== $closing_quote ) {
			$dynamic[ '/(?<=\A|' . $spaces . ')"(\d[.,\d]*)"/' ] = $opening_quote . '$1' . $closing_quote;
		}

		// 9" (double prime)
		if ( '"' !== $double_prime ) {
			$dynamic[ '/(?<=\d)"/' ] = $double_prime;
		}

		// Double quote at start, or preceded by (, {, <, [, -, or spaces, and not followed by spaces.
		if ( '"' !== $opening_quote ) {
			$dynamic[ '/(?<=\A|[([{\-]|&lt;|' . $spaces . ')"(?!' . $spaces . ')/' ] = $opening_quote;
		}

		// Any remaining double quotes.
		if ( '"' !== $closing_quote ) {
			$dynamic[ '/"/' ] = $closing_quote;
		}

		$dynamic_characters['quote'] = array_keys( $dynamic );
		$dynamic_replacements['quote'] = array_values( $dynamic );
		$dynamic = array();

		// Dashes and spaces
		$dynamic[ '/---/' ] = $em_dash;
		$dynamic[ '/(?<=' . $spaces . ')--(?=' . $spaces . ')/' ] = $em_dash;
		$dynamic[ '/(?<!xn)--/' ] = $en_dash;
		$dynamic[ '/(?<=' . $spaces . ')-(?=' . $spaces . ')/' ] = $en_dash;

		$dynamic_characters['dash'] = array_keys( $dynamic );
		$dynamic_replacements['dash'] = array_values( $dynamic );
	}

	// Must do this every time in case plugins use these filters in a context sensitive manner
	/**
	 * Filter the list of HTML elements not to texturize.
	 *
	 * @since 2.8.0
	 *
	 * @param array $default_no_texturize_tags An array of HTML element names.
	 */
	$no_texturize_tags = apply_filters( 'no_texturize_tags', $default_no_texturize_tags );
	/**
	 * Filter the list of shortcodes not to texturize.
	 *
	 * @since 2.8.0
	 *
	 * @param array $default_no_texturize_shortcodes An array of shortcode names.
	 */
	$no_texturize_shortcodes = apply_filters( 'no_texturize_shortcodes', $default_no_texturize_shortcodes );

	$no_texturize_tags_stack = array();
	$no_texturize_shortcodes_stack = array();

	// Look for shortcodes and HTML elements.

	$tagnames = array_keys( $shortcode_tags );
	$tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
	$tagregexp = "(?:$tagregexp)(?![\\w-])"; // Excerpt of get_shortcode_regex().

	$comment_regex =
		  '!'           // Start of comment, after the <.
		. '(?:'         // Unroll the loop: Consume everything until --> is found.
		.     '-(?!->)' // Dash not followed by end of comment.
		.     '[^\-]*+' // Consume non-dashes.
		. ')*+'         // Loop possessively.
		. '(?:-->)?';   // End of comment. If not found, match all input.

	$shortcode_regex =
		  '\['              // Find start of shortcode.
		. '[\/\[]?'         // Shortcodes may begin with [/ or [[
		. $tagregexp        // Only match registered shortcodes, because performance.
		. '(?:'
		.     '[^\[\]<>]+'  // Shortcodes do not contain other shortcodes. Quantifier critical.
		. '|'
		.     '<[^\[\]>]*>' // HTML elements permitted. Prevents matching ] before >.
		. ')*+'             // Possessive critical.
		. '\]'              // Find end of shortcode.
		. '\]?';            // Shortcodes may end with ]]

	$regex =
		  '/('                   // Capture the entire match.
		.     '<'                // Find start of element.
		.     '(?(?=!--)'        // Is this a comment?
		.         $comment_regex // Find end of comment.
		.     '|'
		.         '[^>]+>'       // Find end of element.
		.     ')'
		//. '|'
		//.     $shortcode_regex   // Find shortcodes.
		. ')/s';

	$textarr = preg_split( $regex, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

	foreach ( $textarr as &$curl ) {
		// Only call _wptexturize_pushpop_element if $curl is a delimiter.
		$first = $curl[0];
		if ( '<' === $first && '<!--' === substr( $curl, 0, 4 ) ) {
			// This is an HTML comment delimeter.

			continue;

		} elseif ( '<' === $first && '>' === substr( $curl, -1 ) ) {
			// This is an HTML element delimiter.

			_wptexturize_pushpop_element( $curl, $no_texturize_tags_stack, $no_texturize_tags );

		} elseif ( '' === trim( $curl ) ) {
			// This is a newline between delimiters.  Performance improves when we check this.

			continue;

		} elseif ( '[' === $first && 1 === preg_match( '/^' . $shortcode_regex . '$/', $curl ) ) {
			// This is a shortcode delimiter.

			if ( '[[' !== substr( $curl, 0, 2 ) && ']]' !== substr( $curl, -2 ) ) {
				// Looks like a normal shortcode.
				_wptexturize_pushpop_element( $curl, $no_texturize_shortcodes_stack, $no_texturize_shortcodes );
			} else {
				// Looks like an escaped shortcode.
				continue;
			}

		} elseif ( empty( $no_texturize_shortcodes_stack ) && empty( $no_texturize_tags_stack ) ) {
			// This is neither a delimiter, nor is this content inside of no_texturize pairs.  Do texturize.

			$curl = str_replace( $static_characters, $static_replacements, $curl );

			if ( false !== strpos( $curl, "'" ) ) {
				$curl = preg_replace( $dynamic_characters['apos'], $dynamic_replacements['apos'], $curl );
			}
			if ( false !== strpos( $curl, '"' ) ) {
				$curl = preg_replace( $dynamic_characters['quote'], $dynamic_replacements['quote'], $curl );
			}
			if ( false !== strpos( $curl, '-' ) ) {
				$curl = preg_replace( $dynamic_characters['dash'], $dynamic_replacements['dash'], $curl );
			}

			// 9x9 (times), but never 0x9999
			if ( 1 === preg_match( '/(?<=\d)x-?\d/', $curl ) ) {
				// Searching for a digit is 10 times more expensive than for the x, so we avoid doing this one!
				$curl = preg_replace( '/\b(\d(?(?<=0)[\d\.,]+|[\d\.,]*))x(-?\d[\d\.,]*)\b/', '$1&#215;$2', $curl );
			}
		}
	}
	$text = implode( '', $textarr );

	// Replace each & with &#038; unless it already looks like an entity.
	$text = preg_replace('/&(?!#(?:\d+|x[a-f0-9]+);|[a-z1-4]{1,8};)/i', '&#038;', $text);

	return $text;
}
}


/**
 * Replace double line-breaks without adding `<br />`.
 *
 * Perform most of wpautop() formatting except for the line-break to `br` conversion
 * 
 * @param string $pee The text which has to be formatted.
 * @return string Text which has been converted into correct paragraph tags.
 *
 * @since 4.2.0
 */
if ( !function_exists( "wpautop_nobr" ) ) {
function wpautop_nobr( $pee ) {
  return( wpautop( $pee, false ) );
}
}

