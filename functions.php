<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

}

// Remove offcanvas menu.
remove_theme_support( 'offcanvas-menu' );

// Remove the site title tag.
beans_remove_action( 'beans_site_title_tag' );

// Remove the secondary sidebar.
add_action( 'widgets_init', 'secondary_widget_area' );

// Remove the breadcrumb.
add_filter( 'beans_pre_load_fragment_breadcrumb', '__return_true' );

function secondary_widget_area() {

    beans_deregister_widget_area( 'sidebar_secondary' );

}

// Register a footer widget area.
add_action( 'widgets_init', 'footer_widget_area' );

function footer_widget_area() {

    beans_register_widget_area( array(
        'name' => 'Footer',
        'id' => 'footer',
        'beans_type' => 'grid'
    ) );

}

// Display the footer widget area in the front end.
add_action( 'beans_footer_before_markup', 'display_footer_widget_area' );

function display_footer_widget_area() {

 ?>
  <div class="tm-mega-footer uk-block">
   <div class="uk-container uk-container-center">
      <?php echo beans_widget_area( 'footer' ); ?>
    </div>
  </div>
  <?php

}

// Modify the read more text.
add_filter( 'beans_post_more_link_text_output', 'example_modify_read_more' );

function example_modify_read_more() {

   return 'Read more';

}

// Modify the "Next" post navigation text.
add_filter( 'beans_next_text_post_navigation_output', 'example_next_text_post_navigation' );

function example_next_text_post_navigation( $text ) {

 if ( $post = get_next_post() ) {
    $text = $post->post_title;
  }

 return $text;

}
