<?php

// Move the post image above the post title.
beans_modify_action_hook( 'beans_post_image', 'beans_post_header_before_markup' );
// Remove post content
beans_remove_action( 'beans_post_content');
// Remove post meta info
beans_remove_action( 'beans_post_meta' );
beans_remove_action( 'beans_post_meta_tags' );
// Add responsive grid
beans_wrap_inner_markup( 'beans_content', 'archive_posts_grid', 'div', array(
  'class' => 'uk-grid uk-grid-match',
  'data-uk-grid-margin' => ''
) );
beans_wrap_markup( 'beans_post', 'archive_post_grid_column', 'div', array(
  'class' => 'uk-width-large-1-3 uk-width-medium-1-2',
  'uk-grid-small'
  ) );

// Resize featured image
add_filter( 'beans_edit_post_image_args', 'gpeach_post_image_edit_args' );
function gpeach_post_image_edit_args( $args ) {
  return array_merge( $args, array(
    'resize' => array( 500, 500, true ),
  ) );
}

  // Move the posts pagination after the new grid markup.
 beans_modify_action_hook( 'beans_posts_pagination', 'archive_posts_grid_after_markup' );

// Load the document
beans_load_document();
