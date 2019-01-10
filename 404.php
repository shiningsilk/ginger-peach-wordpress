<?php

add_action( 'beans_content', 'recent_posts_grid' );

function recent_posts_grid() {

  // Get latest posts
  $custom_posts = get_posts( array( 'numberposts' => 6 ) );

  // Remove post meta
  beans_remove_action( 'beans_post_meta' );

  // Add responsive grid
  ?><div id="recent-posts-grid" class="uk-grid uk-grid-match" data-uk-grid-margin=""><?php

  // Global variable 
  global $post;

  // Add posts
  foreach ( $custom_posts as $post ) {

    // Setup the postdata.
    setup_postdata( $post );
    ?><div class="uk-width-large-1-3 uk-width-medium-1-2">
    <article class="uk-article uk-panel-box"><?php

    // Add post image and title
    beans_post_image();
    beans_post_title();

    ?></article></div><?php

  }

  ?></div><?php

}

// Resize featured image
add_filter( 'beans_edit_post_image_args', 'gpeach_post_image_edit_args' );
function gpeach_post_image_edit_args( $args ) {
  return array_merge( $args, array(
    'resize' => array( 500, 500, true ),
    ) );
}

// Load the document
beans_load_document();
