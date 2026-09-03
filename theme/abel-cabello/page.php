<?php
/**
 * Default page template — used for Política de Privacidad / Cookies etc.
 */
get_header();
?>
<style>
  .legal { padding: 160px 0 100px; max-width: 780px; margin: 0 auto; }
  .legal h1 { font-family: var(--serif); text-transform: uppercase; font-size: clamp(2rem,4vw,2.75rem); margin-bottom: 2.5rem; }
  .legal h2 { font-family: var(--serif); font-size: 1.3rem; margin: 2.5rem 0 1rem; }
  .legal p, .legal li { color: var(--gray); font-size: 0.95rem; line-height: 1.7; }
  .legal a { color: var(--gold); text-decoration: underline; }
  .legal ul { padding-left: 1.25rem; }
  .legal table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 0.85rem; }
  .legal th, .legal td { text-align: left; padding: 0.6rem; border-bottom: 1px solid var(--line); color: var(--gray); }
</style>

<div class="container legal">
  <?php while ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
