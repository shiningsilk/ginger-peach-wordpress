<?php

add_filter( 'beans_no_post_article_title_text_output', 'gpeach_no_post_article_title_text' );
function gpeach_no_post_article_title_text() {
       return 'Page not found';
}

add_filter( 'beans_no_post_article_content_text_output', 'gpeach_no_post_article_content_text' );
function gpeach_no_post_article_content_text() {
       return 'Try searching or check out some popular posts';
}




// Add popular posts grid
add_action( 'beans_content', 'popular_posts_grid' );

function popular_posts_grid() {

  // Get latest posts
  $custom_posts = get_posts( array( 'numberposts' => 6, 'orderby' => 'comment_count' ) );

  // Remove post meta
  beans_remove_action( 'beans_post_meta' );

  // Add responsive grid
  ?>
  <div id="recent-posts-grid" class="uk-grid uk-grid-match" data-uk-grid-margin="">
  <?php

  // Global variable
  global $post;

  // Add posts
  foreach ( $custom_posts as $post ) {

    // Setup the postdata.
    setup_postdata( $post );

    ?>
    <div class="uk-width-large-1-3 uk-width-small-1-2"><article class="uk-article uk-panel-box">
    <?php

    // Add post image and title
    beans_post_image();
    beans_post_title();

    ?>
    </article></div>
    <?php

  }

  ?>
  </div>
  <?php

}

// Resize featured image
add_filter( 'beans_edit_post_image_args', 'gpeach_post_image_edit_args' );

function gpeach_post_image_edit_args( $args ) {

  return array_merge( $args, array(
    'resize' => array( 400, 400, true ),
    ) );

}

// Load the document
beans_load_document();
