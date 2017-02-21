<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'generate_parse_attr' ) ) :
/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `genesis_attr_{context}`.
 *
 * @since 1.3.45
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 * @return array Merged and filtered attributes.
 */
function generate_parse_attr( $context, $attributes = array() ) {

    $defaults = array(
        'class' => esc_attr( $context ),
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    // Contextual filter.
    return apply_filters( "generate_attr_{$context}", $attributes, $context );

}
endif;

if ( ! function_exists( 'generate_get_attr' ) ) :
/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `generate_attr_{context}_output`.
 *
 * @since 1.3.45
 *
 * @param string $context    The context, to build filter name.
 * @param array  $attributes Optional. Extra attributes to merge with defaults.
 * @return string String of HTML attributes and values.
 */
function generate_get_attr( $context, $attributes = array() ) {

	$attributes = generate_parse_attr( $context, $attributes );

	$output = '';

	// Cycle through attributes, build tag attribute string.
    foreach ( $attributes as $key => $value ) {

		if ( ! $value ) {
			continue;
		}

		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
		}

    }

    $output = apply_filters( "generate_attr_{$context}_output", $output, $attributes, $context );

    return trim( $output );

}
endif;

if ( ! function_exists( 'generate_attr' ) ) :
/**
 * Print our generatepress_get_attr() function
 *
 * @since 1.3.45
 */
function generate_attr( $context, $attributes = array() ) {
	echo generate_get_attr( $context, $attributes );
}
endif;

if ( ! function_exists( 'generate_body_attributes' ) ) :
/**
 * Build our <body> attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_body', 'generate_body_attributes' );
function generate_body_attributes( $attributes ) {
	
	// Add our body classes
	$attributes['class'] = join( ' ', get_body_class() );
	
	// Set up our itemtype
	$itemtype = 'WebPage';
	
	// Set up blog variable
	$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;
	
	// Change our itemtype if we're on the blog
	$itemtype = ( $blog ) ? 'Blog' : $itemtype;
	
	// Change our itemtype if we're in search results
	$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;
	
	// Add our itemtype
	$attributes['itemtype']  = 'http://schema.org/' . apply_filters( 'generate_body_itemtype', $itemtype );

	// Add itemscope
	$attributes['itemscope'] = true;
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_page_attributes' ) ) :
/**
 * Build our page attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_page', 'generate_page_attributes' );
function generate_page_attributes() {
	
	// Add ID
	$attributes['id'] = 'page';
	
	// Add classes
	$attributes['class'] = 'hfeed site grid-container container grid-parent';
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_primary_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_primary', 'generate_primary_attributes' );
function generate_primary_attributes() {
	
	// Add ID
	$attributes['id'] = 'primary';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_content_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_right_sidebar_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_right-sidebar', 'generate_right_sidebar_attributes' );
function generate_right_sidebar_attributes() {
	
	// Add ID
	$attributes['id'] = 'right-sidebar';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_right_sidebar_class', $classes ) );
	
	// Add itemtype
	$attributes['itemtype'] = 'http://schema.org/WPSideBar';
	
	// Add itemscope
	$attributes['itemscope'] = true;
	
	// Add role
	$attributes['role'] = 'complementary';
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_left_sidebar_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_left-sidebar', 'generate_left_sidebar_attributes' );
function generate_left_sidebar_attributes() {
	
	// Add ID
	$attributes['id'] = 'left-sidebar';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_left_sidebar_class', $classes ) );
	
	// Add itemtype
	$attributes['itemtype'] = 'http://schema.org/WPSideBar';
	
	// Add itemscope
	$attributes['itemscope'] = true;
	
	// Add role
	$attributes['role'] = 'complementary';
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_header_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_header', 'generate_header_attributes' );
function generate_header_attributes() {
	
	// Add ID
	$attributes['id'] = 'masthead';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_header_class', $classes ) );
	
	// Add itemtype
	$attributes['itemtype'] = 'http://schema.org/WPHeader';
	
	// Add itemscope
	$attributes['itemscope'] = true;
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_inside_header_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_inside-header', 'generate_inside_header_attributes' );
function generate_inside_header_attributes() {
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_inside_header_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_navigation_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_navigation', 'generate_navigation_attributes' );
function generate_navigation_attributes() {
	
	// Add ID
	$attributes['id'] = 'site-navigation';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_navigation_class', $classes ) );
	
	// Add itemtype
	$attributes['itemtype'] = 'http://schema.org/SiteNavigationElement';
	
	// Add itemscope
	$attributes['itemscope'] = true;
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_inside_navigation_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_inside-navigation', 'generate_inside_navigation_attributes' );
function generate_inside_navigation_attributes() {
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_inside_navigation_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_main_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_main', 'generate_main_attributes' );
function generate_main_attributes() {
	
	// Add ID
	$attributes['id'] = 'main';
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_main_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_footer_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_footer', 'generate_footer_attributes' );
function generate_footer_attributes() {
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_footer_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_inside_footer_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_inside-footer', 'generate_inside_footer_attributes' );
function generate_inside_footer_attributes() {
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_inside_footer_class', $classes ) );
	
	return $attributes;
	
}
endif;

if ( ! function_exists( 'generate_top_bar_attributes' ) ) :
/**
 * Build our primary content area attributes
 *
 * @since 1.3.45
 */
add_filter( 'generate_attr_top-bar', 'generate_top_bar_attributes' );
function generate_top_bar_attributes() {
	
	// Add classes
	$classes = array();
	$attributes['class'] = implode( ' ', apply_filters( 'generate_top_bar_class', $classes ) );
	
	return $attributes;
	
}
endif;