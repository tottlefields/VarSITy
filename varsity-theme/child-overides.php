<?php

/**
 * Display the page title.
 *
 * @since 1.0.0
 */
function varsity_the_page_title() {
    
    /**
     * Filter the page title display args.
     *
     * @since 1.8.0
     *
     * @var array
     */
    $args = (array) apply_filters( 'primer_the_page_title_args', array(
        'wrapper' => 'h1',
        'atts'    => array( 'class' => 'page-title' ),
        'title'   => varsity_get_the_page_title(),
    ) );
    
    if ( empty( $args['title'] ) ) {
        
        return;
        
    }
    
    $args['atts'] = empty( $args['atts'] ) ? array() : (array) $args['atts'];
    
    foreach ( $args['atts'] as $key => &$value ) {
        
        $value = sprintf( '%s="%s"', sanitize_key( $key ), esc_attr( $value ) );
        
    }
    
    $html = esc_html( $args['title'] );
    
    if ( ! empty( $args['wrapper'] ) ) {
        
        $html = sprintf(
            '<%1$s %2$s>%3$s</%1$s>',
            sanitize_key( $args['wrapper'] ),
            implode( ' ', $args['atts'] ),
            $html
            );
        
    }
    
    echo $html; // xss ok.
    
}

/**
 * Return a page title based on the current page.
 *
 * @since 1.0.0
 *
 * @return string Returns the current page title.
 */
function varsity_get_the_page_title() {
    
    $title = '';
    $post  = get_queried_object();
    
    switch ( true ) {
        
        case is_front_page() :
            
            $title = ( 'posts' === get_option( 'show_on_front' ) ) ? get_theme_mod( 'front_page_title', '' ) : get_the_title( get_option( 'page_on_front' ) );
            
            break;
            
        case is_home() :
            
            $title = get_the_title( get_option( 'page_for_posts' ) );
            
            break;
            
        case is_archive() :
            
            $title = wp_strip_all_tags( get_the_archive_title() );
            
            break;
            
        case is_search() :
            
            $title = sprintf(
            /* translators: search term */
            esc_html__( 'Search Results for: %s', 'primer' ),
            get_search_query()
            );
            
            break;
            
        case is_404() :
            
            $title = esc_html__( '404 Page Not Found', 'primer' );
            
            break;
            
        case is_page() :
            
            $title = get_the_title();
            
            break;
            
        case is_single() :
            
            $title = get_the_title();
            
            break;
            
        case ( ! is_post_type_hierarchical( get_post_type( $post ) ) ) :
            
            $show_on_front  = get_option( 'show_on_front' );
            $page_for_posts = get_option( 'page_for_posts' );
            
            if ( 'post' === $post->post_type && 'posts' !== $show_on_front && ! empty( $page_for_posts ) ) {
                
                $title = get_the_title( $page_for_posts );
                
                break;
                
            }
            
            $labels = get_post_type_labels( get_post_type_object( $post->post_type ) );
            
            $title = isset( $labels->name ) ? $labels->name : false;
            
            break;
            
    } // End switch().
    
    /**
     * Filter the page title.
     *
     * @since 1.0.0
     *
     * @var string
     */
    return (string) apply_filters( 'primer_the_page_title', $title );
    
}

?>