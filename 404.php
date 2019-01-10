<?php

beans_modify_action_callback( 'beans_no_post', 'my_new_no_post' );
/*
 * New callback template to replace the default 'beans_no_post'.
 */
function my_new_no_post() {

  $recent_posts = wp_get_recent_posts(array(
        'numberposts' => 3 // Number of recent posts thumbnails to display

    ));
      foreach( $recent_posts as $recent ) {
          printf( '<li><a href="%1$s">%2$s</a></li>',
              esc_url( get_permalink( $recent['ID'] ) ),
              apply_filters( 'the_title', $recent['post_title'], $recent['ID'] )
          );
      }

}

// Load the document
beans_load_document();
