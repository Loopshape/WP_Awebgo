<?php

function scfp_form_entries_init() {
  $labels = array(
    'name'               => __('Entries', 'scfp'), 
    'singular_name'      => __('Entry', 'scfp'),
    'add_new'            => __('Add New', 'scfp'),
    'add_new_item'       => __('Add New Entry', 'scfp'),
    'edit_item'          => __('Edit Entry', 'scfp'),
    'new_item'           => __('New Entry', 'scfp'),
    'all_items'          => __('Inbox', 'scfp'),
    'view_item'          => __('View Entry', 'scfp'),
    'search_items'       => __('Search Entry', 'scfp'),
    'not_found'          => __('No Entries Found', 'scfp'),
    'not_found_in_trash' => __('No Entries Found in Trash', 'scfp'),
    'parent_item_colon'  => '',
    'menu_name'          => __('Entry', 'scfp')
  );

  $args = array(
    'labels'             => $labels, 
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => 'scfp',
    'show_in_nav_menus'  => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' =>  _x( 'form-entries', 'URL slug'),  'with_front' => false ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => 2,
    'supports'           => array( 
        'title', 
        'editor',
        'thumbnail',
    ),
  );

  register_post_type( 'form-entries', $args );
  
  flush_rewrite_rules();    
}
add_action( 'init', 'scfp_form_entries_init' );
