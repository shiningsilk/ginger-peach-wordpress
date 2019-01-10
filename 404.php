<?php

beans_modify_action_callback( 'beans_no_post', 'my_new_no_post' );
/*
 * New callback template to replace the default 'beans_no_post'.
 */
 function my_new_no_post() {
   	// Get the 6 latests posts.
   	$posts = get_posts( array( 'numberposts' => 3 ) );
     ?>
     <div class="uk-grid">

     <?php
   	foreach ( $posts as $post ) {
   		// Setup the postdata.
   		global $post;
   		setup_postdata( $post ); ?>
         <div class="uk-width-large-1-3 uk-width-medium-1-2">
           <?php
             beans_post_title();
             beans_post_image();
           ?>

         </div> <?php

}
?> </div> <?php

}

// Load the document
beans_load_document();
