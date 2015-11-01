<?php

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "vortex_like_dislike";
	$dir = plugin_dir_url( __FILE__ );
	$domain = 'vortex_system_ld';
	$style = __('Style',$domain);
	
    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => 'Rating System',
        // Name that appears at the top of your panel
        'display_version'      => '2.7.2',
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Rating System', $domain ),
        'page_title'           => __( 'Rating System', $domain),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'rating_system_options',
        // Page slug used to denote the panel
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => false,
		'forced_dev_mode_off'	=> false,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/VortexThemes/rating-system',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/VortexThemes',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
	$args['share_icons'][] = array(
        'url'   => 'http://facebook.com/VortexThemes',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );

    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = '';
    } else {
        $args['intro_text'] = '';
    }

    // Add content after the form.
    $args['footer_text'] = '';

    Redux::setArgs( $opt_name, $args );

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Settings for posts and pages', $domain ),
        'id'     => 'basic',
        'desc'   => __( 'Here you can customize the settings only for posts and pages.For comments go to Settings for Comments.', $domain ),
        'fields' => array(
           array(
			'id'       => 'v-switch-posts',
			'type'     => 'switch', 
			'title'    => __('Turn on like or dislike for posts or pages', $domain),
			'default'  => false,
			),array(
				'id'       => 'v_button_visibility',
				'type'     => 'checkbox',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons position', $domain), 
				'subtitle' => __('Where should the buttons appear?', $domain),
				'desc'     => __('You can check them both if you want.', $domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Before content',$domain),
					'2' => __('After content',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '1',
					'2' => '0', 
				)
			),array(
				'id'       => 'vortex-button-align',
				'type'     => 'select',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons alignment',$domain), 
				'options'  => array(
					'1' => __('Left',$domain),
					'2' => __('Center',$domain),
					'3' => __('Right',$domain)
				),
				'default'  => '1',
			),array(
				'id'       => 'v_button_show',
				'type'     => 'checkbox',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Display buttons on:', $domain), 
				'subtitle' => __('Select where the buttons should be displayed.', $domain),
				'desc'	   =>__('Custom post type single must be checked for bbPress support.Posts Index refers to that page where your post(s) show up with an excerpt and a read more button.',$domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Pages',$domain),
					'2' => __('Posts Index',$domain),
					'3' => __('Single post',$domain),
					'4' => __('Custom post type Index',$domain),
					'5' => __('Custom post type single',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '0', 
					'2' => '1', 
					'3' => '1',
					'4' => '0',
					'5' => '0',
				)
			),array(
				'id'       => 'v_button_style',
				'type'     => 'image_select',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons style', $domain), 
				'subtitle' => __('Here you can change the icons of the buttons.', $domain),
				'options'  => array(
						'1'      => array(
							'alt'   => ''.$style.' 1', 
							'img'   => $dir.'images/1.png'
						),
						'2'      => array(
							'alt'   => ''.$style.' 2', 
							'img'   => $dir.'images/2.png'
						),
						'3'      => array(
							'alt'   => ''.$style.' 3', 
							'img'   => $dir.'images/3.png'
						),
						'4'      => array(
							'alt'   => ''.$style.' 4', 
							'img'   => $dir.'images/4.png'
						),
						'5'      => array(
							'alt'   => ''.$style.' 5', 
							'img'   => $dir.'images/5.png'
						),
						'6'      => array(
							'alt'  => ''.$style.' 6', 
							'img'   => $dir.'images/6.png'
						),
						'7'      => array(
							'alt'   => ''.$style.' 7', 
							'img'   => $dir.'images/7.png'
						),
						'8'      => array(
							'alt'   => ''.$style.' 8', 
							'img'   => $dir.'images/8.png'
						),
						'9'      => array(
							'alt'   => ''.$style.' 9', 
							'img'   => $dir.'images/9.png'
						),
						'10'      => array(
							'alt'   => ''.$style.' 10', 
							'img'   => $dir.'images/10.png'
						),
						'11'      => array(
							'alt'  => ''.$style.' 11', 
							'img'  => $dir.'images/11.png'
						),
						'12'      => array(
							'alt'   => ''.$style.' 12', 
							'img'   => $dir.'images/12.png'
						),
						'13'      => array(
							'alt'   => ''.$style.' 13', 
							'img'   => $dir.'images/13.png'
						),
						'14'      => array(
							'alt'   => ''.$style.' 14', 
							'img'   => $dir.'images/14.png'
						)
					),
				'default' => '1'
			),array(
			'id'       => 'v-switch-columns',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Likes & Dislikes in columns', $domain),
			'subtitle' => __('Show the number of likes and dislikes at "All Posts" in custom columns.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-dislike',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Disable dislike', $domain),
			'subtitle' => __('Turn on this if you want like button only.',$domain),
			'default'  => false,
			)/*,array(
			'id'       => 'v-switch-tooltip',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Enable tooltips', $domain),
			'default'  => false,
			)*/,array(
			'id'       => 'v-switch-anon',
			'type'     => 'switch',
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Anonymous users', $domain),
			'subtitle' => __('If you want to allow anonymous users to vote turn this on.',$domain),
			'desc'	   => __('If you allow anonymous users to like or dislike , results may not be 100% accurate meaning that a person could like or dislike twice or more because it\'s impossible for this plugin to track anonymous users over the internet.The IP of the user is stored so if he changes the IP he can vote again.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-anon-counter',
			'type'     => 'switch',
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Anonymous counter',$domain),
			'subtitle' => __('Hide the counter(number of likes or dislikes) for anonymous users.',$domain),
			'default'  => false,
			),array(
				'id'          => 'vortex-buttons-size',
				'type'        => 'typography',
				'required' => array('v-switch-posts','equals','1'),
				'title'       => __('Buttons size', $domain),
				'google'      => false, 
				'font-backup' => false,
				'font-size'	  => true,
				'text-align'  => false,
				'font-weight' => false,
				'line-height' => false,
				'font-style'  => false,
				'font-family' => false,
				'color'		  => false,
				'output'      => array('.vortex-container-like , .vortex-container-dislike'),
				'units'       =>'px',
				'subtitle'    => __('Here you can change the buttons size with a preview.', $domain),
				'default'     => array(
					'font-size'   => '16px', 
				),
				'preview'	  => array(
					 'text'      => __('The buttons will have the same size as this text.You can use this as a preview for the size.',$domain),
				)
			),array(
				'id'       => 'v_default_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-like, .vortex-p-dislike'),
				'title'    => __('Default color', $domain), 
				'subtitle' => __('Default color of buttons', $domain),
				'validate' => 'color',
				'default'  => '#828384',
			),array(
				'id'       => 'v_like_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Like button ',$domain),
				'output'   => array('.vortex-p-like:hover'),
				'subtitle' => __('Like button mouse over color', $domain),
				'validate' => 'color',
				'default'  => '#4898D6',
			),array(
				'id'       => 'v_like_active_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-like-active'),
				'title'    => __('Like button ', $domain), 
				'subtitle' => __('Like button active color', $domain),
				'validate' => 'color',
				'default'  => '#1B7FCC',
			),array(
				'id'       => 'v_dislike_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-dislike:hover'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button mouse over color', $domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
				'id'       => 'v_dislike_active_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-dislike-active'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button active color', $domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
			'id'       => 'v_exclude_category',
			'type'     => 'select',
			'required' => array('v-switch-posts','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude categories', $domain), 
			'subtitle' => __('Here you can exclude categories where you DON\'T want the buttons to show. ',$domain),
			'desc'	   => __('Only categories that have at least 1 post will be shown.',$domain),
			'data'	   => 'category',
			),array(
			'id'       => 'v_exclude_post_types-p',
			'type'     => 'select',
			'required' => array('v-switch-posts','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude post types', $domain), 
			'subtitle' => __('Here you can exclude post types where you DON\'T want the buttons to show. ',$domain),
			'data'	   => 'post_types',
			),array(
				'id'       => 'v_start_post_like',
				'type'     => 'text',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Number of likes by default', $domain),
				'subtitle' => __('Number of likes by default to new post.', $domain),
				'validate' => 'numeric',
				'default'  => '0'
			),array(
				'id'       => 'v_start_post_dislike',
				'type'     => 'text',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Number of dislikes by default', $domain),
				'subtitle' => __('Number of dislikes by default to new post.', $domain),
				'validate' => 'numeric',
				'default'  => '0'
			),array(
				'id'       => 'v_custom_text',
				'type'     => 'switch', 
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Custom text', $domain),
				'subtitle' => __('Display custom text when user is voting', $domain),
				'default'  => false,
			),array(
				'id'       => 'v_custom_text_post_like',
				'type'     => 'text', 
				'validate' => 'no_html',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Custom text for like', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_post_dislike',
				'type'     => 'text',
				'validate' => 'no_html',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Custom text for dislike', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_post_keep',
				'type'     => 'switch',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Keep custom text', $domain),
				'subtitle' => __('When a user voted and refreshes the page keep showing the custom text for the vote and don\'t display the counter',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_bbpress',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable bbPress support', $domain),
				'subtitle' => __('Custom post type single must be checked for bbPress support.',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_buddybpress',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable buddyPress support', $domain),
				'subtitle' => __('Enable support for buddyPress activities.',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_delete',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable Auto delete post', $domain),
				'default'  => false,
			),array(
				'id'       => 'v_delete_number',
				'type'     => 'text',
				'required' => array(array('v-switch-posts','equals','1'),array('v_enable_delete','equals','1')),
				'title'    => __('Number of dislikes:', $domain),
				'subtitle' => __('Auto delete post at a given number of dislikes', $domain),
				'validate' => 'numeric',
				'default'  => '10'
			)
			
		)
			
    ) );
	
		Redux::setSection( $opt_name, array(
        'title'  => __( 'Settings for comments', $domain ),
        'id'     => 'comments',
        'desc'   => __( 'Here you can customize the settings only for comments.For posts and pages go to Settings for Posts and Pages.', $domain ),
			'fields' => array(
				array(
					'id'       => 'v-switch-comments',
					'type'     => 'switch',
					'title'    => __('Turn on like or dislike for comments', $domain),
					'default'  => false,
				),array(
				'id'       => 'v_button_visibility_comments',
				'type'     => 'checkbox',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Buttons position', $domain), 
				'subtitle' => __('Where should the buttons appear?', $domain),
				'desc'     => __('You can check them both if you want.',$domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Before comment',$domain),
					'2' => __('After comment',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '1', 
					'2' => '0', 
				)
			),array(
				'id'       => 'vortex-button-align-comment',
				'type'     => 'select',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Buttons alignment', $domain), 
				'options'  => array(
					'1' => __('Left',$domain),
					'2' => __('Center',$domain),
					'3' => __('Right',$domain)
				),
				'default'  => '1',
			),array(
				'id'       => 'v_button_style_comment',
				'type'     => 'image_select',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Buttons style', $domain), 
				'subtitle' => __('Here you can change the icons of the buttons.',$domain),
				'options'  => array(
						'1'      => array(
							'alt'   => ''.$style.' 1', 
							'img'   => $dir.'images/1.png'
						),
						'2'      => array(
							'alt'   => ''.$style.' 2', 
							'img'   => $dir.'images/2.png'
						),
						'3'      => array(
							'alt'   => ''.$style.' 3', 
							'img'   => $dir.'images/3.png'
						),
						'4'      => array(
							'alt'   => ''.$style.' 4', 
							'img'   => $dir.'images/4.png'
						),
						'5'      => array(
							'alt'   => ''.$style.' 5', 
							'img'   => $dir.'images/5.png'
						),
						'6'      => array(
							'alt'  => ''.$style.' 6', 
							'img'   => $dir.'images/6.png'
						),
						'7'      => array(
							'alt'   => ''.$style.' 7', 
							'img'   => $dir.'images/7.png'
						),
						'8'      => array(
							'alt'   => ''.$style.' 8', 
							'img'   => $dir.'images/8.png'
						),
						'9'      => array(
							'alt'   => ''.$style.' 9', 
							'img'   => $dir.'images/9.png'
						),
						'10'      => array(
							'alt'   => ''.$style.' 10', 
							'img'   => $dir.'images/10.png'
						),
						'11'      => array(
							'alt'  => ''.$style.' 11', 
							'img'   => $dir.'images/11.png'
						),
						'12'      => array(
							'alt'   => ''.$style.' 12', 
							'img'   => $dir.'images/12.png'
						),
						'13'      => array(
							'alt'   => ''.$style.' 13', 
							'img'   => $dir.'images/13.png'
						),
						'14'      => array(
							'alt'   => ''.$style.' 14', 
							'img'   => $dir.'images/14.png'
						)
					),
				'default' => '1'
			),array(
			'id'       => 'v-switch-columns-comment',
			'type'     => 'switch', 
			'required' => array('v-switch-comments','equals','1'),
			'title'    => __('Likes & Dislikes in columns', $domain),
			'subtitle' => __('Show the number of likes and dislikes at "Comments" in custom columns.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-order-comment',
			'type'     => 'switch', 
			'required' => array('v-switch-comments','equals','1'),
			'title'    => __('Order comments', $domain),
			'subtitle' => __('Order comments by the number of likes they have.No Epoch support.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-dislike-comment',
			'type'     => 'switch', 
			'required' => array('v-switch-comments','equals','1'),
			'title'    => __('Disable dislike', $domain),
			'subtitle' => __('Turn on this if you want like button only.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-anon-comment',
			'type'     => 'switch',
			'required' => array('v-switch-comments','equals','1'),
			'title'    => __('Anonymous users', $domain),
			'subtitle' => __('If you want to allow anonymous users to vote turn this on.',$domain),
			'desc'	   => __('If you allow anonymous users to like or dislike , results may not be 100% accurate meaning that a person could like or dislike twice or more because it\'s impossible for this plugin to track anonymous users over the internet.The IP of the user is stored so if he changes the IP he can vote again.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-anon-counter-comment',
			'type'     => 'switch',
			'required' => array('v-switch-comments','equals','1'),
			'title'    => __('Anonymous counter', $domain),
			'subtitle' => __('Hide the counter(number of likes or dislikes) for anonymous users.',$domain),
			'default'  => false,
			),array(
				'id'          => 'vortex-buttons-size-comment',
				'type'        => 'typography',
				'required' => array('v-switch-comments','equals','1'),
				'title'       => __('Buttons size', $domain),
				'google'      => false, 
				'font-backup' => false,
				'font-size'	  => true,
				'text-align'  => false,
				'font-weight' => false,
				'line-height' => false,
				'font-style'  => false,
				'font-family' => false,
				'color'		  => false,
				'units'       =>'px',
				'subtitle'    => __('Here you can change the buttons size with a preview.',$domain),
				'default'     => array(
					'font-size'   => '16px', 
				),
				'preview'	  => array(
					 'text'      => __('The buttons will have the same size as this text.You can use this as a preview for the size.',$domain),
				)
			),array(
				'id'       => 'v_default_color_comment',
				'type'     => 'color',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Default color', $domain), 
				'subtitle' => __('Default color of buttons', $domain),
				'validate' => 'color',
				'default'  => '#828384',
			),array(
				'id'       => 'v_like_color_comment',
				'type'     => 'color',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Like button ', $domain),
				'subtitle' => __('Like button mouse over color',$domain),
				'validate' => 'color',
				'default'  => '#4898D6',
			),array(
				'id'       => 'v_like_active_color_comment',
				'type'     => 'color',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Like button ', $domain), 
				'subtitle' => __('Like button active color', $domain),
				'validate' => 'color',
				'default'  => '#1B7FCC',
			),array(
				'id'       => 'v_dislike_color_comment',
				'type'     => 'color',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button mouse over color', $domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
				'id'       => 'v_dislike_active_color_comment',
				'type'     => 'color',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button active color',$domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
			'id'       => 'v_exclude_category_comment',
			'type'     => 'select',
			'required' => array('v-switch-comments','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude categories', $domain), 
			'subtitle' => __('Here you can exclude categories where you DON\'T want the buttons to show. ',$domain),
			'desc'	   => __('Only categories that have at least 1 post will be shown.',$domain),
			'data'	   => 'category',
			),array(
			'id'       => 'v_exclude_post_types',
			'type'     => 'select',
			'required' => array('v-switch-comments','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude post types', $domain), 
			'subtitle' => __('Here you can exclude post types where you DON\'T want the buttons to show. ',$domain),
			'data'	   => 'post_types',
			),array(
				'id'       => 'v_start_comment_like',
				'type'     => 'text',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Number of likes by default', $domain),
				'subtitle' => __('Number of likes by default to new comment.', $domain),
				'validate' => 'numeric',
				'default'  => '0'
			),array(
				'id'       => 'v_start_comment_dislike',
				'type'     => 'text',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Number of dislikes by default', $domain),
				'subtitle' => __('Number of dislikes by default to new comment.', $domain),
				'validate' => 'numeric',
				'default'  => '0'
			),array(
				'id'       => 'v_custom_text_com',
				'type'     => 'switch', 
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Custom text', $domain),
				'subtitle' => __('Display custom text when user is voting', $domain),
				'default'  => false,
			),array(
				'id'       => 'v_custom_text_com_like',
				'type'     => 'text', 
				'validate' => 'no_html',
				'required' => array(array('v-switch-comments','equals','1'),array('v_custom_text_com','equals','1')),
				'title'    => __('Custom text for like', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_com_dislike',
				'type'     => 'text',
				'validate' => 'no_html',
				'required' => array(array('v-switch-comments','equals','1'),array('v_custom_text_com','equals','1')),
				'title'    => __('Custom text for dislike', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_com_keep',
				'type'     => 'switch',
				'required' => array(array('v-switch-comments','equals','1'),array('v_custom_text_com','equals','1')),
				'title'    => __('Keep custom text', $domain),
				'subtitle' => __('When a user voted and refreshes the page keep showing the custom text for the vote and don\'t display the counter',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_epoch',
				'type'     => 'switch',
				'required' => array('v-switch-comments','equals','1'),
				'title'    => __('Enable Epoch Support', $domain),
				'default'  => false,
			)
			
			)
		));
		Redux::setSection( $opt_name, array(
        'title'  => __( 'Statistic Dashboard', $domain ),
        'id'     => 'statistic',
		'fields' => array(
				array(
					'id'       => 'v_button_statistic',
					'type'     => 'checkbox',
					'title'    => __('Statistics for:', $domain),
					'subtitle' => __('The statistics will show up in WordPress Dashboard Widget', $domain), 
					'desc'     => __('You can check them both if you want.', $domain),
				 
					//Must provide key => value pairs for multi checkbox options
					'options'  => array(
						'1' => __('Posts',$domain),
						'2' => __('Comments',$domain),
					),
				 
					//See how default has changed? you also don't need to specify opts that are 0.
					'default' => array(
						'1' => '1', 
						'2' => '0', 
					)
				)
			)
		));
	    Redux::setSection( $opt_name, array(
        'title'  => __( 'Translation', $domain ),
        'id'     => 'translation',
        'desc'   => __( 'Here you can translate some basic text.', $domain ),
        'icon'   => 'el el-home',
			'fields' => array(
				array(
					'id'       => 'v-singular-text',
					'type'     => 'text',
					'title'    => __('Singular like  for widget', $domain),
					'subtitle' => __('This appers next to the number of likes in the widget only when the likes equals to 1.', $domain),
					'validate' => 'text',
					'default'  => 'like'
				),array(
					'id'       => 'v-plural-text',
					'type'     => 'text',
					'title'    => __('Plural like  for widget', $domain),
					'subtitle' => __('This appers next to the number of likes in the widget only when the likes is equals to 2 or bigger.', $domain),
					'validate' => 'text',
					'default'  => 'likes'
				),/*array(
					'id'       => 'v-like-text',
					'type'     => 'text',
					'title'    => __('Tooltip like text', $domain),
					'validate' => 'text',
					'default'  => 'I like this'
				),array(
					'id'       => 'v-like-text-yes',
					'type'     => 'text',
					'title'    => __('Tooltip already liked text', $domain),
					'validate' => 'text',
					'default'  => 'Unlike'
				),array(
					'id'       => 'v-dislike-text',
					'type'     => 'text',
					'title'    => __('Tooltip disliked text', $domain),
					'validate' => 'text',
					'default'  => 'I dislike this'
				),array(
					'id'       => 'v-dislike-yes',
					'type'     => 'text',
					'title'    => __('Tooltip already disliked text', $domain),
					'validate' => 'text',
					'default'  => 'Undislike'
				)*/
			)
		));
