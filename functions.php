<?php
/**
 * NESCTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NESCTheme
 */

require_once 'custom-elementor.php';   
require_once 'inc/ajax.php'; 
require_once 'inc/registrants-db.php';


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function nesctheme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on NESCTheme, use a find and replace
		* to change 'nesctheme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'nesctheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'nesctheme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'nesctheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'nesctheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function nesctheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nesctheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'nesctheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nesctheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'nesctheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'nesctheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'nesctheme_widgets_init' );


add_action( 'admin_enqueue_scripts', 'load_admin_style' );
function load_admin_style() {
    wp_register_style( 'admin-styles', get_template_directory_uri() . '/custom-styles//admin-styles.css', false, '1.0.0' );
    
    wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/custom-styles//admin-styles.css', false, '1.0.0' );
}




/**
 * Enqueue scripts and styles.
 */
function nesctheme_scripts() {
	wp_enqueue_style( 'nesctheme-style', get_stylesheet_uri(), array(), _S_VERSION ); 
	wp_enqueue_style( 'main.css', get_template_directory_uri() . '/custom-styles/main.css', array(), '1.0.0');  
	wp_enqueue_style( 'bootstrap.min', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '5.2.0');  
	wp_enqueue_style( 'elementor-styles', get_template_directory_uri() . '/custom-styles/elementor-styles.css', array(), '5.2.0');  
	wp_enqueue_style( 'main', get_stylesheet_directory_uri() . '/fullcalendar/lib/main.min.css','5.11.2','all' );   
	wp_enqueue_style( 'single-event', get_template_directory_uri() . '/custom-styles/single-event.css', array(), '1.0.0');  
	wp_enqueue_style('all-events.css', get_template_directory_uri() . '/custom-styles/all-events.css', array(), '1.0.0'); 
	wp_enqueue_style('mobile', get_template_directory_uri() . '/custom-styles/mobile.css', array(), '1.0.0');

	wp_style_add_data( 'nesctheme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'nesctheme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true ); 
	wp_enqueue_script( 'bootstrap.min', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(), '5.2.0'); 
	wp_enqueue_script( 'header', get_template_directory_uri() . '/custom-scripts/header.js', array(),'3.6.0', true );     
	wp_enqueue_script( 'main', get_template_directory_uri() . '/fullcalendar/lib/main.min.js', array('jquery'),'5.11.2',true); 
	wp_enqueue_script( 'calendar-scripts', get_template_directory_uri() . '/custom-scripts/calendar-scripts.js', array('jquery'),'',true);    
	wp_localize_script('calendar-scripts', 'soul', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));    
	wp_enqueue_script( 'event-form', get_template_directory_uri() . '/custom-scripts/event-form.js', array('jquery'),'3.5.0', true );     
	wp_localize_script('event-form', 'synth', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  

	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nesctheme_scripts' );  



// Register Custom Post Type
function events() {

	$labels = array(
		'name'                  => _x( 'events', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'event', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Events', 'text_domain' ),
		'name_admin_bar'        => __( 'Events', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	
	$args = array(
		'label'                 => __( 'event', 'text_domain' ),
		'description'           => __( 'monthly events for home calendar', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
		'taxonomies'            => array( 'event' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 2,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'		=> 'post', 
		'taxonomies'          => array( 'category' )
	);
	register_post_type( 'events', $args );

}
add_action( 'init', 'events', 0 ); 













/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

