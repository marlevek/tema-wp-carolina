<?php
/**
 * Resultados de busca do blog.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

$search_term   = get_search_query();
$results_count = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
$results_label = sprintf(
	/* translators: %s: total de resultados. */
	_n(
		'%s artigo encontrado para a sua busca.',
		'%s artigos encontrados para a sua busca.',
		$results_count,
		'tema-carolina'
	),
	number_format_i18n( $results_count )
);

if ( 0 === $results_count ) {
	$results_label = __( 'Nenhum artigo foi encontrado com esses termos. Você pode tentar outra combinação abaixo.', 'tema-carolina' );
}

get_header();
?>

<main id="conteudo-principal" class="page-main journal-main">
	<section class="journal-intro journal-intro--archive">
		<div class="container journal-intro__inner">
			<div class="journal-intro__copy" data-reveal>
				<?php tema_carolina_render_breadcrumbs(); ?>
				<span class="eyebrow"><?php esc_html_e( 'Busca', 'tema-carolina' ); ?></span>
				<h1 class="archive-title">
					<?php
					echo esc_html(
						$search_term
							? sprintf(
								/* translators: %s: termo pesquisado. */
								__( 'Resultados para "%s"', 'tema-carolina' ),
								$search_term
							)
							: __( 'Busca no blog', 'tema-carolina' )
					);
					?>
				</h1>
				<p class="journal-intro__lead"><?php echo esc_html( $results_label ); ?></p>
			</div>
			<div class="journal-intro__aside" data-reveal>
				<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>"><?php esc_html_e( 'Voltar para o blog', 'tema-carolina' ); ?></a>
			</div>
		</div>
	</section>

	<?php if ( tema_carolina_get_editorial_categories() ) : ?>
		<section class="topic-nav-section" aria-labelledby="search-topics-title">
			<div class="container">
				<div class="topic-nav-card" data-reveal>
					<div class="topic-nav-card__header">
						<span class="eyebrow"><?php esc_html_e( 'Temas', 'tema-carolina' ); ?></span>
						<h2 id="search-topics-title"><?php esc_html_e( 'Prefere explorar por categoria?', 'tema-carolina' ); ?></h2>
						<p><?php esc_html_e( 'Você também pode navegar pelos temas editoriais para encontrar conteúdos próximos do que procura.', 'tema-carolina' ); ?></p>
					</div>
					<?php
					tema_carolina_render_editorial_topic_navigation(
						array(
							'current_category_id' => 0,
							'active_all'          => true,
						)
					);
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="journal-search-section" aria-labelledby="search-results-form-title">
		<div class="container">
			<div class="journal-search-card" data-reveal>
				<div class="journal-search-card__content">
					<span class="eyebrow"><?php esc_html_e( 'Refinar busca', 'tema-carolina' ); ?></span>
					<h2 id="search-results-form-title"><?php esc_html_e( 'Ajuste os termos e continue explorando o blog', 'tema-carolina' ); ?></h2>
					<p><?php esc_html_e( 'Você pode tentar sinônimos, temas mais amplos ou palavras-chave específicas para encontrar o artigo certo.', 'tema-carolina' ); ?></p>
				</div>
				<?php get_search_form(); ?>
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
						'prev_text' => __( 'Resultados anteriores', 'tema-carolina' ),
						'next_text' => __( 'Próximos resultados', 'tema-carolina' ),
					)
				);
				?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
