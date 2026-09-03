<?php
/**
 * Custom Post Types: Galería, Agenda (eventos), Testimonios
 */

function ac_register_cpts() {

    register_post_type( 'ac_galeria', [
        'labels' => [
            'name'          => 'Galería',
            'singular_name' => 'Elemento de galería',
            'add_new_item'  => 'Añadir foto/vídeo',
            'edit_item'     => 'Editar elemento de galería',
            'all_items'     => 'Galería',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-format-gallery',
        'supports'     => [ 'title', 'thumbnail' ],
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'galeria-item' ],
    ] );

    register_post_type( 'ac_evento', [
        'labels' => [
            'name'          => 'Agenda',
            'singular_name' => 'Evento',
            'add_new_item'  => 'Añadir evento',
            'edit_item'     => 'Editar evento',
            'all_items'     => 'Agenda',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => [ 'title' ],
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'evento' ],
    ] );

    register_post_type( 'ac_testimonio', [
        'labels' => [
            'name'          => 'Testimonios',
            'singular_name' => 'Testimonio',
            'add_new_item'  => 'Añadir testimonio',
            'edit_item'     => 'Editar testimonio',
            'all_items'     => 'Testimonios',
        ],
        'public'       => true,
        'has_archive'  => false,
        'menu_icon'    => 'dashicons-star-filled',
        'supports'     => [ 'title' ],
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'testimonio' ],
    ] );
}
add_action( 'init', 'ac_register_cpts' );
