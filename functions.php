<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

// Remove this action and callback function if you are not adding CSS in the style.css file.
add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

	wp_enqueue_style( ' add_google_fonts ', ' https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:400', false );

}


// Enqueue uikit assets
add_action( 'beans_uikit_enqueue_scripts', 'gpeach_enqueue_uikit_assets');

function gpeach_enqueue_uikit_assets() {

	beans_uikit_enqueue_components( array('sticky'), 'add-ons');
	beans_uikit_enqueue_components( array( 'toggle' ) );

}


// Add sticky header
add_action( 'beans_before_load_document', 'beans_sticky_header');

function beans_sticky_header() {

	beans_add_attribute( 'beans_header', 'data-uk-sticky', "{top:0}" );

}


// Remove off canvas menu
remove_theme_support( 'offcanvas-menu' );
// Remove the breadcrumb.
add_filter( 'beans_pre_load_fragment_breadcrumb', '__return_true' );
// Remove the site title tag.
beans_remove_action( 'beans_site_title_tag' );
// Remove "No comment yet" text
beans_remove_action( 'beans_no_comment' );
// Remove symbol after read more text
beans_remove_markup( 'beans_next_icon[_more_link]' );
// Remove archive titles
beans_remove_action( 'beans_post_archive_title' );
// Remove search title
beans_remove_action( 'beans_post_search_title');
// Remove end post categories
beans_remove_action( 'beans_post_meta_categories' );
// Remove prefixes
beans_remove_output( 'beans_post_meta_date_prefix' );
beans_remove_output( 'beans_post_meta_categories_prefix' );
beans_remove_output( 'beans_post_meta_tags_prefix' );

// Remove the secondary sidebar.
add_action( 'widgets_init', 'secondary_widget_area' );

function secondary_widget_area() {

		beans_deregister_widget_area( 'sidebar_secondary' );

}

// Remove featured image on single posts
add_action( 'wp', 'beans_child_setup_document' );

function beans_child_setup_document() {

  // Only apply if for single view.
 if ( is_single() ) {
    beans_remove_action( 'beans_post_image' );

  }

}

// Remove post author
add_filter( 'beans_post_meta_items', 'beans_child_remove_post_meta_items' );

function beans_child_remove_post_meta_items( $items ) {

 unset( $items['author']['comments'] );
  return $items;

}

// Sort post meta
add_filter( 'beans_post_meta_items', 'sort_meta_items' );

function sort_meta_items( $meta ) {

	$meta = array (
		'date' => 20,
		'categories' => 30,
	);

	return $meta;

}

// Move the post meta above post title
beans_modify_action_hook( 'beans_post_meta', 'beans_post_title_before_markup' );


// Modify category separator
add_filter( 'the_category', 'gpeach_categories_output', 10, 2 );

function gpeach_categories_output( $thelist, $separator ) {

	return str_replace( $separator, ' &bull; ', $thelist );

}

// Modify tag separator
add_filter( 'the_tags', 'gpeach_tags_output', 10, 3 );

function gpeach_tags_output( $tag_list, $before, $sep ) {

	return str_replace( $sep, ' &bull; ', $tag_list );

}


// Modify the read more text.
add_filter( 'beans_post_more_link_text_output', 'gpeach_modify_read_more' );

function gpeach_modify_read_more() {

	return 'Read more';

}

// Add button class to read more link
beans_add_attribute( 'beans_post_more_link', 'class', 'uk-button button' );


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


// Toggle mobile nav
// Hide desktop primary nav
beans_add_attribute( 'beans_menu[_navbar][_primary]', 'class', 'uk-visible-large' );

// Add mobile nav toggle button
add_action( 'beans_primary_menu_append_markup', 'gpeach_primary_menu_toggle' );

function gpeach_primary_menu_toggle() {

 ?><button class="uk-button uk-hidden-large" data-uk-toggle="{target:'#gpeach-primary-mobile-menu'}"><i class="uk-icon-navicon"></i></button><?php

}

// Add primary mobile nav
add_action( 'beans_header_append_markup', 'gpeach_primary_mobile_menu' );

function gpeach_primary_mobile_menu() {

  ?>
  <div id="gpeach-primary-mobile-menu" class="uk-hidden uk-container uk-container-center">
   <div class="uk-panel-box uk-panel-box-secondary uk-margin-top">
     <?php wp_nav_menu( array(
       'theme_location' => has_nav_menu( 'primary' ) ? 'primary' : '',
       'fallback_cb' => 'beans_no_menu_notice',
        'container' => '',
        'beans_type' => 'sidenav' 
     ) ); ?>
   </div>
  </div>
  <?php

}


// Footer credits
beans_modify_action_callback( 'beans_footer_content', 'gpeach_footer_content' );

function gpeach_footer_content() {

	?> <div class="tm-sub-footer uk-text-center"> <p>©
	<?php echo date('Y');
	?> Ginger Peach. Site by <a href="http://kgeorge.co"  target="_blank" title="KGeorge"> KGeorge.</a></p></div>
	<?php

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

beans_remove_attribute( 'beans_post_meta_tags', 'class', 'uk-text-muted');
