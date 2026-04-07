<?php
/**
 * Conteúdo padrão de página.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card--page' ); ?> data-reveal>
	<header class="entry-header">
		<span class="eyebrow"><?php esc_html_e( 'Página', 'tema-carolina' ); ?></span>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="entry-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
