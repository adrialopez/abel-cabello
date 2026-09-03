<?php
/**
 * SEO: title, meta description, Open Graph, Twitter Card, JSON-LD.
 * No SEO plugin is installed — this is intentionally self-contained.
 */

function ac_seo_meta() {
    $uri = get_template_directory_uri();
    $default_image = $uri . '/images/gallery/abel-escenario-01.jpg';

    if ( is_front_page() ) {
        return [
            'title'       => 'Abel Cabello — Showman y Cantante para Bodas y Eventos en Barcelona',
            'description' => 'Abel Cabello, showman y cantante en Barcelona. Shows en directo, DJ y monólogos para bodas, eventos de empresa y fiestas privadas. Más de 80 canciones en repertorio. Reserva tu fecha.',
            'image'       => $default_image,
        ];
    }

    if ( is_page( 'galeria' ) ) {
        return [
            'title'       => 'Galería — Fotos y Vídeos de Abel Cabello en Directo',
            'description' => 'Fotos y vídeos reales de los shows de Abel Cabello en bodas, eventos de empresa y fiestas privadas en Barcelona y alrededores.',
            'image'       => $default_image,
        ];
    }

    if ( is_page( 'politica-de-privacidad' ) || is_page( 'politica-de-cookies' ) ) {
        return [
            'title'       => get_the_title() . ' — Abel Cabello',
            'description' => 'Información legal sobre el tratamiento de datos y el uso de cookies en abelcabello.com.',
            'image'       => $default_image,
        ];
    }

    return [
        'title'       => get_the_title() ? get_the_title() . ' — Abel Cabello' : get_bloginfo( 'name' ),
        'description' => get_bloginfo( 'description' ),
        'image'       => $default_image,
    ];
}

// Keep legal pages out of the XML sitemap (they're set to noindex above)
add_filter( 'wp_sitemaps_posts_query_args', function ( $args, $post_type ) {
    if ( 'page' === $post_type ) {
        $legal = [
            get_page_by_path( 'politica-de-privacidad' ),
            get_page_by_path( 'politica-de-cookies' ),
        ];
        $ids = array_filter( array_map( function ( $p ) { return $p ? $p->ID : 0; }, $legal ) );
        if ( $ids ) {
            $args['post__not_in'] = array_merge( $args['post__not_in'] ?? [], $ids );
        }
    }
    return $args;
}, 10, 2 );

// Custom <title>
add_filter( 'pre_get_document_title', function () {
    return ac_seo_meta()['title'];
} );

add_filter( 'document_title_separator', function () {
    return '—';
} );

// Meta description, Open Graph, Twitter Card
add_action( 'wp_head', function () {
    $meta = ac_seo_meta();
    $url  = is_front_page() ? home_url( '/' ) : get_permalink();
    ?>
    <meta name="description" content="<?php echo esc_attr( $meta['description'] ); ?>" />
    <meta name="theme-color" content="#0a0a0b" />
    <?php if ( is_page( 'politica-de-privacidad' ) || is_page( 'politica-de-cookies' ) ) : ?>
    <meta name="robots" content="noindex, follow" />
    <?php endif; ?>

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Abel Cabello" />
    <meta property="og:locale" content="es_ES" />
    <meta property="og:title" content="<?php echo esc_attr( $meta['title'] ); ?>" />
    <meta property="og:description" content="<?php echo esc_attr( $meta['description'] ); ?>" />
    <meta property="og:image" content="<?php echo esc_url( $meta['image'] ); ?>" />
    <meta property="og:url" content="<?php echo esc_url( $url ); ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo esc_attr( $meta['title'] ); ?>" />
    <meta name="twitter:description" content="<?php echo esc_attr( $meta['description'] ); ?>" />
    <meta name="twitter:image" content="<?php echo esc_url( $meta['image'] ); ?>" />
    <?php
}, 1 );

// JSON-LD: LocalBusiness / EntertainmentBusiness + reviews, only on the front page
add_action( 'wp_head', function () {
    if ( ! is_front_page() ) {
        return;
    }
    $uri = get_template_directory_uri();

    $reviews_query = new WP_Query( [
        'post_type'      => 'ac_testimonio',
        'posts_per_page' => 10,
    ] );
    $review_count = max( 1, $reviews_query->found_posts );
    wp_reset_postdata();

    $schema = [
        '@context'          => 'https://schema.org',
        '@type'             => 'EntertainmentBusiness',
        'name'              => 'Abel Cabello',
        'description'       => 'Showman y cantante en Barcelona: shows en directo, DJ y monólogos para bodas, eventos de empresa y fiestas privadas.',
        'url'               => home_url( '/' ),
        'image'             => $uri . '/images/gallery/abel-escenario-01.jpg',
        'telephone'         => '+34629220296',
        'priceRange'        => '€€',
        'areaServed'        => [ '@type' => 'City', 'name' => 'Barcelona' ],
        'address'           => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Barcelona',
            'addressRegion'   => 'Cataluña',
            'addressCountry'  => 'ES',
        ],
        'sameAs'            => [
            'https://instagram.com/abel.cabello',
        ],
        'aggregateRating'   => [
            '@type'       => 'AggregateRating',
            'ratingValue' => '5',
            'reviewCount' => (string) $review_count,
        ],
    ];
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
    <?php
}, 2 );
