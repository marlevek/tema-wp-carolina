<?php
/**
 * Card de post para arquivos, blog e destaques.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories    = tema_carolina_get_post_category_links( get_the_ID() );
$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'blog-card' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> data-reveal>
	<?php if ( $thumbnail_url ) : ?>
		<a
			class="post-card__thumb"
			href="<?php the_permalink(); ?>"
			aria-hidden="true"
			tabindex="-1"
			style="background-image: url('<?php echo esc_url( $thumbnail_url ); ?>');"
		></a>
	<?php endif; ?>

	<div class="post-card__content">
		<div class="post-card__meta">
			<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
		</div>

		<h2 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<div class="post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a class="text-link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Ler artigo', 'tema-carolina' ); ?>
		</a>
	</div>
</article>
