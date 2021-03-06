<?php

// Remove featured image
beans_remove_action( 'beans_post_image' );

// Modify tag separator
add_filter( 'the_tags', 'gpeach_tags_output', 10, 3 );

function gpeach_tags_output( $tag_list, $before, $sep ) {

  return str_replace( $sep, ' &bull; ', $tag_list );

}

// Remove tag class
beans_remove_attribute( 'beans_post_meta_tags', 'class', 'uk-text-muted');

// Modify the "Previous" post navigation text.
add_filter( 'beans_previous_text_post_navigation_output', 'gpeach_previous_text_post_navigation' );

function gpeach_previous_text_post_navigation() {

  if ( $post = get_previous_post() ) {
    $text = $post->post_title;
  }

  return $text;

}

// Modify the "Next" post navigation text.
add_filter( 'beans_next_text_post_navigation_output', 'gpeach_next_text_post_navigation' );

function gpeach_next_text_post_navigation( $text ) {

  if ( $post = get_next_post() ) {
    $text = $post->post_title;
  }

 return $text;

}

// Modify "Previous" post icon
beans_replace_attribute( 'beans_previous_icon', 'class', 'uk-icon-angle-double-left', 'uk-icon-caret-left');

// Modify "Next" post icon
beans_replace_attribute( 'beans_next_icon', 'class', 'uk-icon-angle-double-right', 'uk-icon-caret-right');

// Remove "No comment yet" text
beans_remove_action( 'beans_no_comment' );

// Remove class from comment list
beans_remove_attribute( 'beans_comments', 'class', 'uk-panel-box');

// Remove comment badges
beans_remove_action( 'beans_comment_badges');

// Remove button primary class from comment submit
beans_remove_attribute( 'beans_comment_form_submit', 'class', 'uk-button-primary');

// Move tags to article content
beans_modify_action_hook( 'beans_post_meta_tags', 'beans_post_content_append_markup');

// Add comment link
beans_modify_action_hook( 'beans_post_meta_comments_shortcode', 'beans_post_meta_tags_after_markup');

// Add class to comment link
beans_add_attribute( 'beans_post_meta_comments', 'class', 'gpeach-post-meta-comments' );

// Move comment form above comment list
beans_modify_action_hook( 'beans_comment_form', 'beans_comments_prepend_markup');

//Move comment divider above comment list header
beans_modify_action_hook( 'beans_comment_form_divider', 'beans_comments_title_before_markup');

// Add related posts
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
