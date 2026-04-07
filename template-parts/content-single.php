<?php
/**
 * Conteúdo individual de post.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = tema_carolina_get_post_category_links( get_the_ID() );
$tags       = get_the_tag_list( '', '' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card--single' ); ?> data-reveal>
	<header class="entry-header entry-header--single">
		<div class="entry-header__meta">
			<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
		</div>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="entry-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail entry-thumbnail--single">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php if ( $tags ) : ?>
		<footer class="entry-footer">
			<p class="footer-heading"><?php esc_html_e( 'Temas do artigo', 'tema-carolina' ); ?></p>
			<div class="entry-taxonomy entry-taxonomy--tags"><?php echo wp_kses_post( $tags ); ?></div>
		</footer>
	<?php endif; ?>
</article>
