<?php

// Only affects the blog page. Really no need for the if statement I think...

// Setup theme
beans_add_smart_action( 'beans_before_load_document', 'theme_index_setup_document' );
function theme_index_setup_document() {

  // Not used on single posts or pages.
  if ( !is_singular() && !is_page() ) {

       // Responsive posts grid.
       beans_wrap_inner_markup( 'beans_content', 'beans_child_posts_grid', 'div', array(
       'class' => 'uk-grid uk-grid-match',
       'data-uk-grid-margin' => ''
       ) );

       beans_wrap_markup( 'beans_post', 'beans_child_post_grid_column', 'div', array(
      'class' => 'uk-width-large-1-3 uk-width-medium-1-2'
       ) );

      // Move the posts pagination after the new grid markup.
      beans_modify_action_hook( 'beans_posts_pagination', 'beans_child_posts_grid_after_markup' );


      // Post preview
      beans_add_attribute( 'beans_post', 'class', 'beans-post');

      // Move the post image to the top of the post header
      beans_modify_action_hook( 'beans_post_image', 'beans_post_header_prepend_markup');
      beans_add_attribute( 'beans_post_image', 'class', 'post-image');

      // Remove post meta tags
      beans_remove_action( 'beans_post_meta_tags' );




     // Post article
     beans_add_attribute( 'beans_post_title', 'class', 'post-title' );

     // Post title
     beans_add_attribute( 'beans_post_title', 'class', 'uk-margin-small-top uk-h3' );
     }

  }

  // Resize post image (filter)
  beans_add_smart_action( 'beans_edit_post_image_args', 'banks_index_post_image_args' );
  function banks_index_post_image_args( $args ) {
  $args['resize'] = array( 430, 250, true );
  return $args;
  }


  // Adds excerpt
  add_filter( 'the_content', 'beans_child_modify_post_content' );
  function beans_child_modify_post_content( $content ) {
      // Stop here if we are on a single view.
      if ( is_singular() )
      return $content;

      // Return the excerpt() if it exists other truncate.
      if ( has_excerpt() )
         $content = '<p>' . get_the_excerpt() . '</p>';
      else
         $content = '<p>' . wp_trim_words( get_the_content(), 20, '...' ) . '</p>';

      // Return content and readmore.
      return $content . '<p>' . beans_post_more_link() . '</p>';
  }



// See also this similar code: https://gist.github.com/ThierryA/9bd05dd7beb459828591

// Load beans document
beans_load_document();
