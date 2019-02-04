<?php

// Move the post image above the post title.
beans_modify_action_hook( 'beans_post_image', 'beans_post_header_before_markup' );

// Remove post content
beans_remove_action( 'beans_post_content');

// Remove post meta info
beans_remove_action( 'beans_post_meta' );
beans_remove_action( 'beans_post_meta_tags' );

// Move search title before grid
beans_modify_action_hook( 'beans_post_search_title', 'search_posts_grid_before_markup');

// Add responsive grid
beans_wrap_inner_markup( 'beans_content', 'search_posts_grid', 'div', array(

  'class' => 'gpeach-grid uk-grid uk-grid-match',
  'data-uk-grid-margin' => ''

  ));

beans_wrap_markup( 'beans_post', 'search_post_grid_column', 'div', array(

  'class' => 'uk-width-large-1-3 uk-width-small-1-2',

  ));

// Resize featured image
add_filter( 'beans_edit_post_image_args', 'gpeach_post_image_edit_args' );

function gpeach_post_image_edit_args( $args ) {

  return array_merge( $args, array(
    'resize' => array( 400, 400, true ),
  ));

}

// Move the posts pagination after the new grid markup.
 beans_modify_action_hook( 'beans_posts_pagination', 'search_posts_grid_after_markup' );

// Load the document
beans_load_document();
