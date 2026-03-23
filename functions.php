<?php
/**
 * Wunderflats Hub — functions.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Theme Setup ────────────────────────────────── */
function wfhub_setup() {
    load_theme_textdomain( 'wunderflats-hub', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );

    add_image_size( 'wfhub-hero',  1200, 800, true );
    add_image_size( 'wfhub-card',  800,  500, true );
    add_image_size( 'wfhub-thumb', 400,  250, true );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'wunderflats-hub' ),
        'footer'  => __( 'Footer Menu',  'wunderflats-hub' ),
    ) );
}
add_action( 'after_setup_theme', 'wfhub_setup' );

/* ── Content Width ──────────────────────────────── */
function wfhub_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'wfhub_content_width', 0 );

/* ── Enqueue Assets ─────────────────────────────── */
function wfhub_scripts() {
    wp_enqueue_style(
        'wfhub-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style( 'wfhub-style', get_stylesheet_uri(), array( 'wfhub-fonts' ), '2.1.0' );

    wp_enqueue_script(
        'wfhub-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '2.1.0',
        true
    );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'wfhub_scripts' );

/* ── Widgets / Sidebars ─────────────────────────── */
function wfhub_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar', 'wunderflats-hub' ),
        'id'            => 'sidebar-main',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Column 2', 'wunderflats-hub' ),
        'id'            => 'footer-2',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );
}
add_action( 'widgets_init', 'wfhub_widgets_init' );

/* ── Excerpt ────────────────────────────────────── */
function wfhub_excerpt_length() {
    return 22;
}
add_filter( 'excerpt_length', 'wfhub_excerpt_length' );

function wfhub_excerpt_more() {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'wfhub_excerpt_more' );

/* ── Reading Time ───────────────────────────────── */
function wfhub_reading_time( $post_id = null ) {
    $content    = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( strip_tags( $content ) );
    $minutes    = max( 1, (int) ceil( $word_count / 200 ) );
    return sprintf( _n( '%d min read', '%d min read', $minutes, 'wunderflats-hub' ), $minutes );
}

/* ── First Category Helpers ─────────────────────── */
function wfhub_first_category( $post_id = null ) {
    $cats = get_the_category( $post_id );
    return $cats ? esc_html( $cats[0]->name ) : '';
}

function wfhub_first_category_link( $post_id = null ) {
    $cats = get_the_category( $post_id );
    if ( ! $cats ) return '';
    return '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
}

/* ── Tag CSS class helper ───────────────────────── */
function wfhub_tag_class( $name ) {
    $map = array(
        'legal'    => 'tag-r',
        'finance'  => 'tag-g',
        'market'   => 'tag-p',
        'platform' => 'tag-p',
        'tips'     => 'tag-p',
        'gdpr'     => 'tag-b',
        'news'     => 'tag-b',
        'moving'   => 'tag-b',
        'tenants'  => 'tag-b',
    );
    $key = strtolower( $name );
    foreach ( $map as $needle => $class ) {
        if ( strpos( $key, $needle ) !== false ) return $class;
    }
    return 'tag-p';
}

/* ── Thumbnail or placeholder image ────────────── */
function wfhub_thumb_or_placeholder( $size, $alt = '' ) {
    static $ph_imgs = array(
        'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=900&q=80',
        'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&q=80',
        'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80',
        'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=800&q=80',
        'https://images.unsplash.com/photo-1556909114-44e3e9699e2d?w=800&q=80',
        'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80',
        'https://images.unsplash.com/photo-1574362848149-11496d93a7c7?w=800&q=80',
        'https://images.unsplash.com/photo-1560185009-5bf9f2849488?w=800&q=80',
    );
    static $index = 0;

    if ( has_post_thumbnail() ) {
        the_post_thumbnail( $size, array( 'alt' => esc_attr( $alt ) ) );
    } else {
        echo '<img src="' . esc_url( $ph_imgs[ $index % count( $ph_imgs ) ] ) . '" alt="' . esc_attr( $alt ) . '">';
        $index++;
    }
}

/* ── Customizer ─────────────────────────────────── */
function wfhub_customize_register( $wp_customize ) {

    /* Announcement Bar */
    $wp_customize->add_section( 'wfhub_announcement', array(
        'title'    => __( 'Announcement Bar', 'wunderflats-hub' ),
        'priority' => 25,
    ) );

    $wp_customize->add_setting( 'wfhub_ann_text', array(
        'default'           => '🏠 New: German Rent Reform 2025 — what landlords need to know',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_setting( 'wfhub_ann_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_setting( 'wfhub_ann_link', array(
        'default'           => 'Read now →',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'wfhub_ann_text', array(
        'label'   => __( 'Announcement Text', 'wunderflats-hub' ),
        'section' => 'wfhub_announcement',
        'type'    => 'text',
    ) );
    $wp_customize->add_control( 'wfhub_ann_url', array(
        'label'   => __( 'Announcement URL', 'wunderflats-hub' ),
        'section' => 'wfhub_announcement',
        'type'    => 'url',
    ) );
    $wp_customize->add_control( 'wfhub_ann_link', array(
        'label'   => __( 'Link Text', 'wunderflats-hub' ),
        'section' => 'wfhub_announcement',
        'type'    => 'text',
    ) );

    /* Hero */
    $wp_customize->add_section( 'wfhub_hero', array(
        'title'    => __( 'Hero Settings', 'wunderflats-hub' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'wfhub_hero_post', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'wfhub_hero_post', array(
        'label'       => __( 'Featured Post ID (leave blank for latest)', 'wunderflats-hub' ),
        'section'     => 'wfhub_hero',
        'type'        => 'text',
    ) );

    /* Newsletter */
    $wp_customize->add_section( 'wfhub_newsletter', array(
        'title'    => __( 'Newsletter Section', 'wunderflats-hub' ),
        'priority' => 40,
    ) );

    $wp_customize->add_setting( 'wfhub_nl_heading', array(
        'default'           => 'Stay ahead of the German rental market',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_setting( 'wfhub_nl_subheading', array(
        'default'           => 'Weekly insights, legal updates and practical tips for landlords and tenants — straight to your inbox. Join 12,000+ readers.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'wfhub_nl_heading', array(
        'label'   => __( 'Heading', 'wunderflats-hub' ),
        'section' => 'wfhub_newsletter',
        'type'    => 'text',
    ) );
    $wp_customize->add_control( 'wfhub_nl_subheading', array(
        'label'   => __( 'Subheading', 'wunderflats-hub' ),
        'section' => 'wfhub_newsletter',
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'wfhub_customize_register' );
