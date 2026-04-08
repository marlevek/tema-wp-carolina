<?php
/**
 * Card de post para arquivos, blog e destaques.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$categories     = tema_carolina_get_post_category_links( $post_id );
$thumbnail_url  = get_the_post_thumbnail_url( $post_id, 'blog-card' );
$reading_time   = tema_carolina_get_reading_time_label( $post_id );
$updated_label  = tema_carolina_get_post_updated_label( $post_id );
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
			<div class="post-card__meta-primary">
				<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<?php if ( $reading_time ) : ?>
					<span class="post-card__meta-detail"><?php echo esc_html( $reading_time ); ?></span>
				<?php endif; ?>
			</div>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
			<?php if ( $updated_label ) : ?>
				<p class="post-card__meta-note"><?php echo esc_html( $updated_label ); ?></p>
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
