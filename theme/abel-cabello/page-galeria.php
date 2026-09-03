<?php
/**
 * Template Name: Galería completa
 */
get_header();
?>
<style>
  .page-hero { padding-top: 160px; padding-bottom: 60px; text-align: center; }
  .page-hero p { color: var(--gray); max-width: 520px; margin: 1rem auto 0; }
  .gal-filters { display:flex; gap:0.75rem; justify-content:center; margin-bottom: 2.5rem; }
  .gal-filter { padding:0.55rem 1.25rem; border-radius:999px; border:1px solid var(--line); color:var(--gray); font-size:0.82rem; cursor:pointer; background:none; font-family:var(--sans); }
  .gal-filter.active { border-color: var(--gold); color: var(--gold); box-shadow: var(--glow-pink); }
  .full-gal-grid { display:grid; grid-template-columns:repeat(4,1fr); grid-auto-rows:240px; gap:8px; padding-bottom:100px; }
  @media (max-width: 900px) { .full-gal-grid { grid-template-columns:repeat(2,1fr); grid-auto-rows:200px; } }
</style>

<section class="page-hero container">
  <p class="section-label">En directo</p>
  <h1 style="font-family:var(--serif);font-size:clamp(2.2rem,5vw,3.5rem);text-transform:uppercase;">Galería</h1>
  <p>Fotos y clips reales de los últimos eventos de Abel Cabello.</p>
</section>

<div class="container">
  <div class="gal-filters">
    <button class="gal-filter active" data-filter="all">Todo</button>
    <button class="gal-filter" data-filter="image">Fotos</button>
    <button class="gal-filter" data-filter="video">Vídeos</button>
  </div>

  <div class="full-gal-grid" id="gallery-grid">
    <?php
    $gal_query = new WP_Query( [
        'post_type'      => 'ac_galeria',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ] );
    if ( $gal_query->have_posts() ) :
        while ( $gal_query->have_posts() ) : $gal_query->the_post();
            $tipo    = get_field( 'tipo' ) ?: 'foto';
            $type_js = ( 'video' === $tipo ) ? 'video' : 'image';
            $imagen  = get_field( 'imagen' );
            $video   = get_field( 'video_archivo' );
            $leyenda = get_field( 'leyenda' ) ?: get_the_title();
            ?>
            <div class="gal-item" data-type="<?php echo esc_attr( $type_js ); ?>" data-src="<?php echo esc_url( 'video' === $tipo ? $video : $imagen ); ?>" <?php if ( 'video' === $tipo ) : ?>data-poster="<?php echo esc_url( $imagen ); ?>"<?php endif; ?>>
              <img src="<?php echo esc_url( $imagen ); ?>" alt="<?php echo esc_attr( $leyenda ); ?>" loading="lazy" />
              <?php if ( 'video' === $tipo ) : ?>
                <div class="gal-play"><svg width="40" height="40" viewBox="0 0 24 24" fill="#fff"><circle cx="12" cy="12" r="11" fill="rgba(10,10,11,0.55)" stroke="#fff" stroke-width="1"/><path d="M10 8l6 4-6 4V8z"/></svg></div>
              <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else : ?>
      <p style="color:var(--gray-dim);">Todavía no hay elementos en la galería.</p>
    <?php endif; ?>
  </div>
</div>

<div class="lightbox" id="lightbox">
  <button class="lightbox-close" id="lightbox-close">&times;</button>
  <button class="lightbox-nav lightbox-prev" id="lightbox-prev">&#8249;</button>
  <div class="lightbox-content" id="lightbox-content"></div>
  <button class="lightbox-nav lightbox-next" id="lightbox-next">&#8250;</button>
</div>

<script>
  document.querySelectorAll('.gal-filter').forEach(function(btn) {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.gal-filter').forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var filter = btn.getAttribute('data-filter');
      document.querySelectorAll('#gallery-grid .gal-item').forEach(function(item) {
        var show = filter === 'all' || item.getAttribute('data-type') === filter;
        item.style.display = show ? '' : 'none';
      });
    });
  });
</script>

<?php get_footer(); ?>
