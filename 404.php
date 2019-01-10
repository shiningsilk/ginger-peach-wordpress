<?php

beans_modify_action_callback( 'beans_no_post', 'my_new_no_post' );
/*
 * New callback template to replace the default 'beans_no_post'.
 */
function my_new_no_post() {
  	// Get the 6 latests posts.
  	$posts = get_posts( array( 'numberposts' => 4 ) );

  	foreach ( $posts as $post ) {
  		// Setup the postdata.
  		global $post;
  		setup_postdata( $post );

  		// Display post title and image using Beans fragments.
  		beans_post_title();
  		beans_post_image();
  	}

}



// Load the document
beans_load_document();
