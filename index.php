<?php
/**
 * Template fallback do tema.
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
				<span class="eyebrow"><?php esc_html_e( 'Conteúdos', 'tema-carolina' ); ?></span>
				<h1 class="archive-title"><?php esc_html_e( 'Atualizações do site', 'tema-carolina' ); ?></h1>
				<p class="journal-intro__lead"><?php esc_html_e( 'Uma visão geral dos conteúdos publicados no tema, com a mesma atmosfera editorial do restante do site.', 'tema-carolina' ); ?></p>
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
