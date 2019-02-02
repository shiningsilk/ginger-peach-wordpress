<?php
add_action( 'beans_comments_before_markup', 'related_posts_tags', 5 );

/*
add_action( 'beans_post_meta_tags_after_markup', 'gpeach_social_share');

function gpeach_social_share() {
  global $post;

  // page url
  $url = urlencode(get_permalink($post));

  $gpeachurl = esc_url($url);

  $gpeachThumbnail = get_post_thumbnail_id( $post->ID );

  ?><div class="gpeach-social-share uk-float-right uk-display-inline-block">

    <a href='http://twitter.com/home?status=Reading: <?php echo $url ?>' target="_blank"><i class="uk-icon-small uk-icon-twitter uk-icon-hover"></i></a>

    <a href="http://www.pinterest.com/pin/create/button/?url=' . echo $url ' &media=<?php if(has_post_thumbnail()) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" class="simple-share ss-pinterest" target="_blank" rel="nofollow"><i class="uk-icon-small uk-icon-pinterest-p uk-icon-hover"></i></a>
  </div>
  <?php
}*/

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

      $related .= '<div class="uk-width-medium-1-4 uk-width-small-2-4"><a href="' . get_permalink() . '" title="' . get_the_title() .'">' . $img . '</a><h4 class="uk-article-title uk-text-center"><a href="' . get_permalink() . '">'. get_the_title() .'</a></h4></div>';

      }

   }

    if ( $related ) {

      printf( '<div class="related-posts uk-block"><div class="uk-container uk-container-center"><h3 class="uk-text-center">Other interesting things</h3><div class="uk-grid">%s</div></div></div>', $related );

    }

   wp_reset_query();

}


// Load the document
beans_load_document();
