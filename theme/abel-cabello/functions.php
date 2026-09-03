<?php
/**
 * Abel Cabello Theme — functions.php
 */

function ac_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );

    register_nav_menus( [
        'primary' => __( 'Navegación principal', 'abel-cabello' ),
    ] );
}
add_action( 'after_setup_theme', 'ac_theme_setup' );

function ac_enqueue_assets() {
    $ver = '1.0.1';
    $uri = get_template_directory_uri();

    wp_enqueue_style( 'ac-fonts',
        'https://fonts.googleapis.com/css2?family=Monoton&family=Righteous&family=Manrope:wght@400;500;600;700;800&display=swap',
        [], null
    );
    wp_enqueue_style( 'ac-style', $uri . '/assets/css/main.css', [ 'ac-fonts' ], $ver );
    wp_enqueue_script( 'ac-main', $uri . '/assets/js/main.js', [], $ver, true );
}
add_action( 'wp_enqueue_scripts', 'ac_enqueue_assets' );

function ac_month_es( $n ) {
    $months = [ 1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic' ];
    return $months[ $n ] ?? '';
}

require_once get_template_directory() . '/inc/cpt.php';

if ( function_exists( 'acf_add_local_field_group' ) ) {
    require_once get_template_directory() . '/inc/acf-fields.php';
}
