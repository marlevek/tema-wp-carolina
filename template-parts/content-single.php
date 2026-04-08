<?php
/**
 * Conteúdo individual de post.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id        = get_the_ID();
$categories     = tema_carolina_get_post_category_links( $post_id );
$tags           = get_the_tag_list( '', '' );
$reading_time   = tema_carolina_get_reading_time_label( $post_id );
$updated_label  = tema_carolina_get_post_updated_label( $post_id );
$intro          = tema_carolina_get_post_intro( $post_id );
$signature_data = tema_carolina_get_editorial_signature();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card--single' ); ?> data-reveal>
	<header class="entry-header entry-header--single">
		<div class="entry-header__meta">
			<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( $reading_time ) : ?>
				<span class="entry-meta-pill"><?php echo esc_html( $reading_time ); ?></span>
			<?php endif; ?>
			<?php if ( $updated_label ) : ?>
				<span class="entry-meta-pill"><?php echo esc_html( $updated_label ); ?></span>
			<?php endif; ?>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
		</div>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<p class="entry-byline">
			<?php
			printf(
				/* translators: 1: autora, 2: cargo, 3: credencial. */
				esc_html__( 'Por %1$s, %2$s | %3$s', 'tema-carolina' ),
				$signature_data['name'],
				$signature_data['role'],
				$signature_data['credential']
			);
			?>
		</p>
		<?php if ( $intro ) : ?>
			<p class="entry-intro"><?php echo esc_html( $intro ); ?></p>
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

	<section class="entry-author-note" aria-labelledby="entry-author-note-title">
		<div class="entry-author-note__header">
			<span class="eyebrow"><?php esc_html_e( 'Assinatura editorial', 'tema-carolina' ); ?></span>
			<h2 id="entry-author-note-title"><?php echo esc_html( $signature_data['name'] ); ?></h2>
			<p class="entry-author-note__meta"><?php echo esc_html( $signature_data['role'] . ' | ' . $signature_data['credential'] ); ?></p>
		</div>
		<p class="entry-author-note__description"><?php echo esc_html( $signature_data['description'] ); ?></p>
		<div class="entry-author-note__actions">
			<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_blog_about_url() ); ?>"><?php esc_html_e( 'Conhecer a Carol', 'tema-carolina' ); ?></a>
			<a class="text-link" href="<?php echo esc_url( tema_carolina_get_main_site_section_url( 'agendar' ) ); ?>"><?php esc_html_e( 'Agendar conversa', 'tema-carolina' ); ?></a>
		</div>
	</section>

	<?php if ( $tags ) : ?>
		<footer class="entry-footer">
			<p class="footer-heading"><?php esc_html_e( 'Temas do artigo', 'tema-carolina' ); ?></p>
			<div class="entry-taxonomy entry-taxonomy--tags"><?php echo wp_kses_post( $tags ); ?></div>
		</footer>
	<?php endif; ?>
</article>
