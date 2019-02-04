<?php

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

add_action( 'wp_enqueue_scripts', 'beans_child_enqueue_assets' );

function beans_child_enqueue_assets() {

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'gpeach_responsive_menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ));

}

// Enqueue uikit assets
add_action( 'beans_uikit_enqueue_scripts', 'gpeach_enqueue_uikit_assets');

function gpeach_enqueue_uikit_assets() {

	beans_uikit_enqueue_components( array('sticky'), 'add-ons');

	beans_uikit_enqueue_components( array( 'toggle' ) );

}

// Add sticky header
beans_add_attribute( 'beans_header', 'data-uk-sticky', "{top:0}" );

// Add sticky last widget
beans_add_attribute( 'beans_widget_panel_recent-posts', 'data-uk-sticky', '{top:30, media:767}' );

// Remove the secondary sidebar.
add_action( 'widgets_init', 'secondary_widget_area' );

function secondary_widget_area() {

		beans_deregister_widget_area( 'sidebar_secondary' );

}

// Remove off canvas menu
remove_theme_support( 'offcanvas-menu' );

// Remove the breadcrumb.
add_filter( 'beans_pre_load_fragment_breadcrumb', '__return_true' );

// Remove the site title tag.
beans_remove_action( 'beans_site_title_tag' );

// Remove symbol after read more text
beans_remove_markup( 'beans_next_icon[_more_link]' );

// Remove end post categories
beans_remove_action( 'beans_post_meta_categories' );

// Remove post meta prefixes
beans_remove_output( 'beans_post_meta_date_prefix' );
beans_remove_output( 'beans_post_meta_categories_prefix' );
beans_remove_output( 'beans_post_meta_tags_prefix' );

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

// Modify the read more text.
add_filter( 'beans_post_more_link_text_output', 'gpeach_modify_read_more' );

function gpeach_modify_read_more() {

	return 'Read more';

}

// Add button class to read more link
beans_add_attribute( 'beans_post_more_link', 'class', 'uk-button button' );

// Add widget title border
add_action( 'beans_widget_title_after_markup', 'gpeach_border');

function gpeach_border() {
	?><div class="divider"></div><?php
}

// Hide desktop primary nav
beans_add_attribute( 'beans_menu[_navbar][_primary]', 'class', 'uk-visible-large' );

// Add mobile nav toggle button
add_action( 'beans_primary_menu_append_markup', 'gpeach_primary_menu_toggle' );

function gpeach_primary_menu_toggle() {

	?>
		<button class="uk-button uk-hidden-large" data-uk-toggle="{target:'#gpeach-mobile-menu'}" aria-label="mobile-button"><i class="uk-icon-navicon"></i></button>
	<?php

}

// Add primary mobile nav
add_action( 'beans_header_append_markup', 'gpeach_mobile_menu' );

function gpeach_mobile_menu() {

  ?>
  <div id="gpeach-mobile-menu" class="uk-hidden uk-container uk-container-center">
  <div class="uk-panel-box">
  <?php
	wp_nav_menu( array(
		'menu_class' => 'gpeach-menu',
    'theme_location' => has_nav_menu( 'primary' ) ? 'primary' : '',
    'fallback_cb' => 'beans_no_menu_notice',
    'container' => '',
    'beans_type' => 'mobile'
  ) );
	?>
	</div>
  </div>
	<?php

}


// Change number of posts on home page
add_filter('pre_get_posts', 'limit_home_posts');

function limit_home_posts($query){

   if ($query->is_home && $query->is_main_query) {
        $query->set('posts_per_page', 6);
    }

    return $query;

}

// Footer credits
beans_modify_action_callback( 'beans_footer_content', 'gpeach_footer_content' );

function gpeach_footer_content() {

	?>
	<div class="tm-sub-footer uk-text-center"> <p>©<?php echo date('Y');?>
	Ginger Peach. Site by <a href="http://kgeorge.co"  target="_blank" title="KGeorge"> KG.</a></p></div>
	<?php

}

// Display the footer widget area in the front end.
add_action( 'beans_footer_before_markup', 'display_footer_widget_area' );

function display_footer_widget_area() {

	?>
	<div class="gpeach-footer uk-block"><?php echo beans_widget_area( 'footer' ); ?>
  </div>

  <?php

}

// Register a footer widget area.
add_action( 'widgets_init', 'footer_widget_area' );

function footer_widget_area() {

    beans_register_widget_area( array(
        'name' => 'Footer',
        'id' => 'footer',
        'beans_type' => 'geach-insta'
    ) );

}
