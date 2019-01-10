<?php

add_action( 'beans_before_load_document', 'home_excerpts' );

function home_excerpts() {

  // Post excerpts
  add_filter( 'the_content', 'beans_child_modify_post_content' );
  function beans_child_modify_post_content( $content ) {
        // Returns the custom excerpt or truncated content with read more link.
      return sprintf(
          '<p>%s</p><p>%s</p>',
          has_excerpt() ? get_the_excerpt() : wp_trim_words( $content, 50, '...' ),
          beans_post_more_link()

      );

  }

  // Move the post image above the post title.
  beans_modify_action_hook( 'beans_post_image', 'beans_post_header_before_markup' );

  // Sort post meta
  add_filter( 'beans_post_meta_items', 'sort_meta_items' );
  function sort_meta_items( $meta ) {

    $meta = array (
      'date' => 20, // priority
      //'author' => 10, // priority
      'comments' => 40, // priority
      'categories' => 30,
    //  'tags' => 50
    );

  // Remove post meta prefix
  beans_remove_output( 'beans_post_meta_categories_prefix' );

return $meta;
}

  // Remove bottom post meta info
  beans_remove_action( 'beans_post_meta_tags' );
  beans_remove_action( 'beans_post_meta_categories' );

  	// Change featured image size on blog page
  add_filter( 'beans_edit_post_image_args', 'gpeach_post_image_edit_args' );

  function gpeach_post_image_edit_args( $args ) {
  		return array_merge( $args, array(
  				'resize' => array( 400, 400, true ),
  		) );
  	}


}



// Load the document which is always needed at the bottom of template files.
beans_load_document();
