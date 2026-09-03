<?php
/**
 * Front page — Abel Cabello
 */
get_header();
$uri = get_template_directory_uri();
?>

<!-- ============ HERO ============ -->
<section class="hero" id="top">
  <div class="hero-slider" id="hero-slider">
    <div class="hero-slide active" style="background-image:url('<?php echo esc_url( $uri ); ?>/images/gallery/abel-escenario-01.jpg')"></div>
    <div class="hero-slide" style="background-image:url('<?php echo esc_url( $uri ); ?>/images/gallery/abel-grito-escenario-01.jpg')"></div>
    <div class="hero-slide" style="background-image:url('<?php echo esc_url( $uri ); ?>/images/gallery/abel-dramatico-01.jpg')"></div>
    <div class="hero-slide" style="background-image:url('<?php echo esc_url( $uri ); ?>/images/gallery/abel-publico-02.jpg')"></div>
  </div>
  <div class="hero-overlay"></div>

  <div class="hero-content">
    <p class="hero-tag">Showman · Cantante · Barcelona</p>
    <h1>Abel <em>Cabello</em></h1>
    <p class="hero-sub">
      Pop, rock, rumba y boleros de los 60 a hoy — con la especialidad en los 80 y 90, en español e inglés.
      Un showman polifacético que llena la pista de música, humor y complicidad con el público.
    </p>
    <div class="hero-cta">
      <a href="#contacto" class="btn btn-gold">Reserva tu fecha</a>
      <a href="#servicios" class="btn btn-outline">Ver servicios</a>
    </div>
    <div class="hero-trust fade-up">
      <span>★★★★★ <strong>5.0</strong> en opiniones</span>
      <span class="hero-trust-sep">·</span>
      <span>Mejor Profesional 2019–2023</span>
      <span class="hero-trust-sep">·</span>
      <span>Barcelona y alrededores</span>
    </div>
  </div>

  <div class="hero-dots" id="hero-dots"></div>
  <div class="hero-scroll">Descubre más ↓</div>
</section>

<!-- ============ SERVICIOS ============ -->
<section class="servicios" id="servicios">
  <div class="container">
    <div class="servicios-head fade-up">
      <p class="section-label">Qué ofrezco</p>
      <h2>Complementa tu evento</h2>
      <p>Show musical con sonido y luces propias, DJ para alargar la fiesta, monólogos con humor a medida
        y fotografía para guardar el recuerdo. Todo pensado para que solo tengas que disfrutar.</p>
    </div>

    <div class="serv-grid">
      <div class="serv-card fade-up">
        <div class="serv-card-img"><img src="<?php echo esc_url( $uri ); ?>/images/gallery/abel-escenario-01.jpg" alt="Show musical Abel Cabello" /></div>
        <div class="serv-card-body">
          <h3>Show musical</h3>
          <p>Repertorio a medida con sonido, luces, humo y pantallas — todo el equipo incluido.</p>
          <span class="serv-price">Desde 350€</span>
        </div>
      </div>
      <div class="serv-card fade-up">
        <div class="serv-card-img"><img src="<?php echo esc_url( $uri ); ?>/images/brand/servicio-dj.jpg" alt="DJ Abel Cabello" /></div>
        <div class="serv-card-body">
          <h3>DJ</h3>
          <p>Sesión para alargar la fiesta cuando el show termina — la pista no para.</p>
          <span class="serv-price">A consultar</span>
        </div>
      </div>
      <div class="serv-card fade-up">
        <div class="serv-card-img"><img src="<?php echo esc_url( $uri ); ?>/images/brand/servicio-monologos.jpg" alt="Monólogos Abel Cabello" /></div>
        <div class="serv-card-body">
          <h3>Monólogos</h3>
          <p>Humor en directo, con complicidad y guiños al público — el toque más cercano del show.</p>
          <span class="serv-price">A consultar</span>
        </div>
      </div>
      <div class="serv-card fade-up">
        <div class="serv-card-img"><img src="<?php echo esc_url( $uri ); ?>/images/brand/servicio-fotografia.jpg" alt="Fotografía de evento" /></div>
        <div class="serv-card-body">
          <h3>Fotografía</h3>
          <p>Cobertura fotográfica del evento para que el recuerdo dure para siempre.</p>
          <span class="serv-price">A consultar</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ GALERÍA ============ -->
<section class="galeria" id="galeria">
  <div class="container">
    <div class="galeria-head fade-up">
      <div>
        <p class="section-label">En directo</p>
        <h2>Galería</h2>
        <p>Un vistazo a los últimos eventos — fotos y clips reales de escenario.</p>
      </div>
    </div>

    <div class="gal-grid fade-up" id="gallery-grid">
      <?php
      // Featured tile: explicitly marked via ACF "destacada", not by position —
      // positional (e.g. "every 5th item") breaks whenever posts are added/edited/reordered.
      $featured_query = new WP_Query( [
          'post_type'      => 'ac_galeria',
          'posts_per_page' => 1,
          'meta_query'     => [ [ 'key' => 'destacada', 'value' => '1', 'compare' => '=' ] ],
      ] );
      $featured_id = $featured_query->have_posts() ? $featured_query->posts[0]->ID : 0;
      wp_reset_postdata();

      $gal_query = new WP_Query( [
          'post_type'      => 'ac_galeria',
          'posts_per_page' => 9,
          'orderby'        => 'menu_order date',
          'order'          => 'ASC',
          'post__not_in'   => $featured_id ? [ $featured_id ] : [],
      ] );
      if ( $featured_id || $gal_query->have_posts() ) :
          $i = 0;
          $posts_to_show = $featured_id ? array_merge( [ get_post( $featured_id ) ], array_slice( $gal_query->posts, 0, 8 ) ) : $gal_query->posts;
          foreach ( $posts_to_show as $gal_post ) :
              setup_postdata( $gal_post );
              $i++;
              $tipo    = get_field( 'tipo', $gal_post->ID ) ?: 'foto';
              $imagen  = get_field( 'imagen', $gal_post->ID );
              $video   = get_field( 'video_archivo', $gal_post->ID );
              $leyenda = get_field( 'leyenda', $gal_post->ID ) ?: get_the_title( $gal_post );
              $is_featured = $featured_id ? ( $gal_post->ID === $featured_id ) : ( 1 === $i );
              $extra_class = $is_featured ? ' wide tall' : '';
              ?>
              <div class="gal-item<?php echo esc_attr( $extra_class ); ?>" data-type="<?php echo esc_attr( $tipo ); ?>" data-src="<?php echo esc_url( 'video' === $tipo ? $video : $imagen ); ?>" <?php if ( 'video' === $tipo ) : ?>data-poster="<?php echo esc_url( $imagen ); ?>"<?php endif; ?>>
                <img src="<?php echo esc_url( $imagen ); ?>" alt="<?php echo esc_attr( $leyenda ); ?>" loading="lazy" />
                <?php if ( 'video' === $tipo ) : ?>
                  <div class="gal-play"><svg width="40" height="40" viewBox="0 0 24 24" fill="#fff"><circle cx="12" cy="12" r="11" fill="rgba(10,10,11,0.55)" stroke="#fff" stroke-width="1"/><path d="M10 8l6 4-6 4V8z"/></svg></div>
                <?php endif; ?>
              </div>
          <?php endforeach;
          wp_reset_postdata();
      else : ?>
        <p style="color:var(--gray-dim);">Todavía no hay elementos en la galería. Añádelos desde <em>Galería</em> en el escritorio de WordPress.</p>
      <?php endif; ?>
    </div>

    <div class="gal-footer fade-up">
      <a href="<?php echo esc_url( home_url( '/galeria/' ) ); ?>" class="btn btn-outline">Ver galería completa</a>
    </div>
  </div>
</section>

<div class="lightbox" id="lightbox">
  <button class="lightbox-close" id="lightbox-close">&times;</button>
  <button class="lightbox-nav lightbox-prev" id="lightbox-prev">&#8249;</button>
  <div class="lightbox-content" id="lightbox-content"></div>
  <button class="lightbox-nav lightbox-next" id="lightbox-next">&#8250;</button>
</div>

<!-- ============ TESTIMONIOS ============ -->
<section class="testimonios" id="testimonios">
  <div class="container">
    <div class="testi-head fade-up">
      <p class="section-label">Opiniones</p>
      <h2>Lo que dicen de mí</h2>
    </div>
    <div class="testi-grid">
      <?php
      $testi_query = new WP_Query( [
          'post_type'      => 'ac_testimonio',
          'posts_per_page' => 3,
      ] );
      if ( $testi_query->have_posts() ) :
          while ( $testi_query->have_posts() ) : $testi_query->the_post();
              $texto      = get_field( 'texto' );
              $autor      = get_field( 'autor' ) ?: 'Cliente verificado';
              $evento_t   = get_field( 'evento' );
              $valoracion = (int) ( get_field( 'valoracion' ) ?: 5 );
              ?>
              <div class="testi-card fade-up">
                <div class="testi-stars"><?php echo str_repeat( '★', max( 1, min( 5, $valoracion ) ) ); ?></div>
                <p class="testi-text">"<?php echo esc_html( $texto ); ?>"</p>
                <div class="testi-author"><?php echo esc_html( $autor ); ?></div>
                <?php if ( $evento_t ) : ?><div class="testi-event"><?php echo esc_html( $evento_t ); ?></div><?php endif; ?>
              </div>
          <?php endwhile;
          wp_reset_postdata();
      else :
          $fallback = [
              [ 'Abel hizo que la fiesta fuera inolvidable. Profesional de principio a fin y consiguió que todo el mundo, mayores y pequeños, estuviera en la pista.', 'Fiesta privada' ],
              [ 'Un showman de verdad. El repertorio, la puesta en escena y el trato con los invitados fueron perfectos. Lo recomiendo sin duda.', 'Evento de empresa' ],
              [ 'Contratamos el show + DJ y fue todo un acierto. Abel se adapta al público y sabe leer la sala como nadie.', 'Boda' ],
          ];
          foreach ( $fallback as $t ) : ?>
            <div class="testi-card fade-up">
              <div class="testi-stars">★★★★★</div>
              <p class="testi-text">"<?php echo esc_html( $t[0] ); ?>"</p>
              <div class="testi-author">Cliente verificado</div>
              <div class="testi-event"><?php echo esc_html( $t[1] ); ?></div>
            </div>
          <?php endforeach;
      endif; ?>
    </div>
  </div>
</section>

<!-- ============ BIO ============ -->
<section class="bio" id="bio">
  <div class="container bio-grid">
    <div class="bio-image fade-up">
      <img src="<?php echo esc_url( $uri ); ?>/images/gallery/abel-retrato-chaqueta.jpg" alt="Abel Cabello en directo" />
    </div>
    <div class="bio-text">
      <p class="section-label fade-up">Sobre mí</p>
      <h2 class="fade-up">Cercano en el escenario,<br><em>profesional</em> en cada detalle.</h2>
      <p class="fade-up">
        Empecé mi carrera profesional tras pasar por «Lluvia de Estrellas» de TVE, donde el público me
        descubrió — y desde entonces no he dejado de subirme a un escenario. Dos años de gira por toda
        España después, he tenido la suerte de actuar en salas como <strong>Luz de Gas</strong> y en el
        <strong>Palau de la Música Catalana</strong>.
      </p>
      <p class="fade-up">
        Me defino como un showman polifacético: canto pop, rock, rumba, melódico y boleros de los años 60
        hasta hoy, con los 80 y los 90 como mi terreno favorito, en español e inglés. Y entre canción y
        canción, siempre hay hueco para el humor — el monólogo y la complicidad con el público son parte
        de mi sello.
      </p>
      <div class="bio-badges fade-up">
        <span class="badge">TVE — Lluvia de Estrellas</span>
        <span class="badge">Luz de Gas, Barcelona</span>
        <span class="badge">Palau de la Música Catalana</span>
        <span class="badge">80+ canciones en repertorio</span>
      </div>
      <div class="awards fade-up">
        <div class="award"><span class="award-year">2019</span><span class="award-label">Mejor profesional</span></div>
        <div class="award"><span class="award-year">2020</span><span class="award-label">Mejor profesional</span></div>
        <div class="award"><span class="award-year">2021</span><span class="award-label">Mejor profesional</span></div>
        <div class="award"><span class="award-year">2023</span><span class="award-label">Mejor profesional</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ AGENDA ============ -->
<section class="agenda" id="agenda">
  <div class="container">
    <div class="agenda-head fade-up">
      <p class="section-label">Próximas fechas</p>
      <h2>Agenda</h2>
      <p>Estas son algunas de las próximas actuaciones. ¿Buscas fecha para tu evento? Escríbeme y lo miramos.</p>
    </div>

    <div class="agenda-list fade-up">
      <?php
      $evt_query = new WP_Query( [
          'post_type'      => 'ac_evento',
          'posts_per_page' => 6,
          'meta_key'       => 'fecha',
          'orderby'        => 'meta_value',
          'order'          => 'ASC',
      ] );
      if ( $evt_query->have_posts() ) :
          while ( $evt_query->have_posts() ) : $evt_query->the_post();
              $fecha_raw = get_field( 'fecha' );
              $ubicacion = get_field( 'ubicacion' );
              $tipo_evt  = get_field( 'tipo_evento' );
              $estado    = get_field( 'estado' ) ?: 'confirmado';
              $day = $month = '·&nbsp;·';
              if ( $fecha_raw ) {
                  $ts    = DateTime::createFromFormat( 'd/m/Y', $fecha_raw );
                  $day   = $ts ? $ts->format( 'd' ) : $day;
                  $month = $ts ? ac_month_es( (int) $ts->format( 'n' ) ) : $month;
              }
              ?>
              <div class="agenda-row">
                <div class="agenda-date"><span class="day"><?php echo esc_html( $day ); ?></span><span class="month"><?php echo esc_html( $month ); ?></span></div>
                <div class="agenda-info">
                  <h4><?php the_title(); ?></h4>
                  <span><?php echo esc_html( trim( $tipo_evt . ( $ubicacion ? ' — ' . $ubicacion : '' ), ' —' ) ); ?></span>
                </div>
                <div class="agenda-status<?php echo 'disponible' === $estado ? ' open' : ''; ?>"><?php echo esc_html( ucfirst( $estado ) ); ?></div>
              </div>
          <?php endwhile;
          wp_reset_postdata();
      else : ?>
        <div class="agenda-row">
          <div class="agenda-date"><span class="day">·&nbsp;·</span><span class="month">2026</span></div>
          <div class="agenda-info">
            <h4>Disponible para nuevas fechas</h4>
            <span>Bodas, eventos de empresa y fiestas privadas</span>
          </div>
          <div class="agenda-status open">Disponible</div>
        </div>
      <?php endif; ?>
    </div>

    <div class="agenda-cta fade-up">
      <a href="#contacto" class="btn btn-gold">Consultar disponibilidad</a>
    </div>
  </div>
</section>

<!-- ============ CONTACTO ============ -->
<section class="contacto" id="contacto">
  <div class="container contacto-grid">
    <div class="contacto-info fade-up">
      <p class="section-label">Booking</p>
      <h2>Hablemos de <em>tu evento</em></h2>
      <p>Cuéntame qué tipo de evento organizas, la fecha y dónde será, y te preparo una propuesta a medida.
        Respondo lo antes posible.</p>
    </div>

    <div class="contacto-form fade-up">
      <div class="contacto-direct">
        <a href="https://wa.me/34629220296" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.1-1.7-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.7 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5C10 9 9.5 7.7 9.3 7.2c-.2-.5-.4-.4-.5-.4h-.5c-.2 0-.5.1-.7.3-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3z"/><path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.7 1.5 5.3L2 22l4.9-1.3C8.4 21.5 10.2 22 12 22c5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.6 0-3.2-.4-4.6-1.3l-.3-.2-3.2.8.8-3.1-.2-.3C3.4 14.4 3 13.2 3 12c0-4.4 3.6-8 9-8s9 3.6 9 8-4.6 8-9 8z"/></svg>
          WhatsApp
        </a>
        <a href="tel:+34629220296">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          629 22 02 96
        </a>
        <a href="mailto:hola@abelcabello.com">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 6l10 7 10-7"/></svg>
          hola@abelcabello.com
        </a>
        <a href="https://instagram.com/abel.cabello" target="_blank" rel="noopener">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          @abel.cabello
        </a>
      </div>
      <p class="contacto-response-note">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        Suelo responder en menos de 24h.
      </p>
      <?php
      if ( shortcode_exists( 'contact-form-7' ) ) {
          echo do_shortcode( '[contact-form-7 id="111" title="Booking"]' );
      } else {
          echo '<p style="color:var(--gray-dim);">Formulario de booking pendiente de configurar (Contact Form 7).</p>';
      }
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
