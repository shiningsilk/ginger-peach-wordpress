<?php
add_action( 'beans_comments_before_markup', 'related_posts_tags', 5 );

function related_posts_tags() {

  global $post;

  $count = 0;
  $postIDs = array( $post->ID );
  $related = '';
  $tags = wp_get_post_tags( $post->ID );
  $tagIDs = array();

  foreach($tags as $individual_tag) {

     $tag_ids[] = $individual_tag->term_id;

   }

  $args=array(

    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'posts_per_page'=>4,
    'caller_get_posts'=>1

  );

  $tag_query = new WP_Query( $args );

  if ( $tag_query->have_posts() ) {
    while ( $tag_query->have_posts() ) {
      $tag_query->the_post();
      $img = get_the_post_thumbnail( $post->ID, 'thumbnail');

      $related .= '<div class="uk-width-large-1-4 uk-width-medium-2-4 uk-width-small-2-4"><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . $img . '</a><h3><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">'. get_the_title() .'</a></h3></div>';

      }

   }

    if ( $related ) {

      printf( '<hr><div class="related-posts uk-block"><div class="uk-container uk-container-center"><h2 class="uk-text-center">You might like</h2><div class="uk-grid">%s</div></div></div>', $related );

    }

   wp_reset_query();

}


// Load the document
beans_load_document();
