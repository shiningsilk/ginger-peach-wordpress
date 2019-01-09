<?php

// Enqueue UIkit assets.
add_action( 'beans_uikit_enqueue_scripts', 'search_enqueue_uikit_assets' );

function search_enqueue_uikit_assets() {

 beans_uikit_enqueue_components( array( 'grid' ), 'add-ons' );

}

// Display posts in a responsive dynamic grid.
add_action( 'beans_before_load_document', 'search_posts_grid' );

function search_posts_grid() {
  // Remove search title
  beans_remove_action( 'beans_post_search_title');
  // Move the post image above the post title.
  beans_modify_action_hook( 'beans_post_image', 'beans_post_title_before_markup' );
  // Remove post content
  beans_remove_action( 'beans_post_content');
  // Remove post meta info
  beans_remove_action( 'beans_post_meta' );
  beans_remove_action( 'beans_post_meta_tags' );
  beans_remove_action( 'beans_post_meta_categories' );
  // Add grid.
  beans_wrap_inner_markup( 'beans_content', 'search_posts_grid', 'div', array(
   'data-uk-grid' => "{gutter: 20}",
  ) );
  beans_wrap_markup( 'beans_post', 'search_post_grid_column', 'div', array(
    'class' => 'uk-width-large-1-3 uk-width-medium-1-2',
  ) );

  // Resize featured image
  add_filter( 'beans_edit_post_image_args', 'myprefix_post_image_edit_args' );
  function myprefix_post_image_edit_args( $args ) {
      return array_merge( $args, array(
          'resize' => array( 300, 300, true ),
      ) );
    }

  // Move the posts pagination after the new grid markup.
 beans_modify_action_hook( 'beans_posts_pagination', 'search_posts_grid_after_markup' );

}





// Load the document which is always needed at the bottom of template files.
beans_load_document();
