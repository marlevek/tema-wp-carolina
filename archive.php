<?php
/**
 * Template para arquivos.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo-principal" class="page-main journal-main">
	<section class="journal-intro journal-intro--archive">
		<div class="container journal-intro__inner">
			<div class="journal-intro__copy" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Arquivo', 'tema-carolina' ); ?></span>
				<h1 class="archive-title"><?php the_archive_title(); ?></h1>
				<?php if ( get_the_archive_description() ) : ?>
					<div class="archive-description journal-intro__lead"><?php the_archive_description(); ?></div>
				<?php else : ?>
					<p class="journal-intro__lead"><?php esc_html_e( 'Conteúdos organizados por tema para facilitar a navegação pelo blog.', 'tema-carolina' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="journal-intro__aside" data-reveal>
				<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>"><?php esc_html_e( 'Ver todos os artigos', 'tema-carolina' ); ?></a>
			</div>
		</div>
	</section>

	<section class="journal-listing">
		<div class="container">
			<?php if ( have_posts() ) : ?>
				<div class="posts-grid posts-grid--journal">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'archive' );
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => __( 'Artigos anteriores', 'tema-carolina' ),
						'next_text' => __( 'Próximos artigos', 'tema-carolina' ),
					)
				);
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
