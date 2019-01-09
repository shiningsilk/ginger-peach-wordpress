<?php

// Enqueue UIkit assets.
add_action( 'beans_uikit_enqueue_scripts', 'archive_enqueue_uikit_assets' );

function archive_enqueue_uikit_assets() {

 beans_uikit_enqueue_components( array( 'grid' ), 'add-ons' );

}

// Display posts in a responsive dynamic grid.
add_action( 'beans_before_load_document', 'archive_posts_grid' );

function archive_posts_grid() {
  // Remove post content
  beans_remove_action( 'beans_post_content');
  // Remove post meta info
  beans_remove_action( 'beans_post_meta' );
  beans_remove_action( 'beans_post_meta_tags' );
  beans_remove_action( 'beans_post_meta_categories' );
  // Add grid.
  beans_wrap_inner_markup( 'beans_content', 'archive_posts_grid', 'div', array(
   'data-uk-grid' => "{gutter: 20, controls: '#tm-grid-filter'}",
  ) );
  beans_wrap_markup( 'beans_post', 'archive_post_grid_column', 'div', array(
    'class' => 'uk-width-large-1-3 uk-width-medium-1-2',
  ) );

  // Move the posts pagination after the new grid markup.
 beans_modify_action_hook( 'beans_posts_pagination', 'archive_posts_grid_after_markup' );

}

// Add posts filter.
add_action( 'beans_content_before_markup', 'archive_posts_filter' );

function archive_posts_filter() {

  $categories = get_categories( array(
    'parent' => 0,
  ) );

  ?>
  <ul id="tm-grid-filter" class="uk-subnav uk-container-center">
    <?php foreach ( $categories as $category ) : ?>
     <li data-uk-filter="<?php echo esc_attr( $category->slug ); ?>">
        <a href="#"><?php echo esc_attr( $category->name ); ?></a>
      </li>
   <?php endforeach; ?>
  </ul>
 <?php
}

// Add filter data to each post.
add_filter( 'archive_post_grid_column_attributes', 'archive_post_attributes' );

function archive_post_attributes( $attributes ) {

  // Get the categories and build and array with its slugs.
 $categories = wp_list_pluck( get_the_category( get_the_ID() ), 'slug' );

  return array_merge( $attributes, array(
   'data-uk-filter' => implode( ',', (array) $categories ), // automatically escaped.
  ) );

}

// Load the document which is always needed at the bottom of template files.
beans_load_document();
