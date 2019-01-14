<?php
add_action( 'beans_comments_before_markup', 'related_posts_categories', 5 );

function related_posts_categories() {

   global $post;

   $count = 0;
   $postIDs = array( $post->ID );
    $related = '';
    $cats = wp_get_post_categories( $post->ID );
    $catIDs = array();

    foreach ( $cats as $cat ) {
     $catIDs[] = $cat;
   }

   $args = array(
      'category__in'          => $catIDs,
     'post__not_in'          => $postIDs,
      'showposts'             => 4,
     //'ignore_sticky_posts'   => 1,
     'orderby'               => 'rand',
      'tax_query'             => array(
       array(
          'taxonomy'  => 'post_format',
         'field'     => 'slug',
          'terms'     => array(
           'post-format-link',
           'post-format-status',
           'post-format-aside',
            'post-format-quote'
         ),
          'operator' => 'NOT IN'
        )
     )
   );

    $cat_query = new WP_Query( $args );

   if ( $cat_query->have_posts() ) {
     while ( $cat_query->have_posts() ) {
        $cat_query->the_post();
       $img = get_the_post_thumbnail( $post->ID, 'thumbnail' );

       $related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . $img . '</a><h3><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">'. get_the_title() .'</a></h3></li>';
      }
   }

   if ( $related ) {
     printf( '<hr><div class="related-posts uk-block"><div class="uk-container uk-container-center"><h4 class="uk-h2 uk-text-center">You might like</h4><ul class="uk-grid uk-grid-width-1-4">%s</ul></div></div>', $related );
    }

   wp_reset_query();



}
// Load the document
beans_load_document();
