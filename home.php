<?php
/**
 * Página principal do blog.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$posts_page_id = (int) get_option( 'page_for_posts' );
$blog_title    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog da Carolina', 'tema-carolina' );
$blog_intro    = $posts_page_id ? get_the_excerpt( $posts_page_id ) : '';
$categories    = tema_carolina_get_editorial_categories();

if ( ! $blog_intro && $posts_page_id ) {
	$blog_intro = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $posts_page_id ) ), 32 );
}

if ( ! $blog_intro ) {
	$blog_intro = __( 'Um espaço para reflexões sobre vínculos, terapia, relações e cuidado emocional, com a mesma delicadeza da experiência institucional do site.', 'tema-carolina' );
}

get_header();
?>

<main id="conteudo-principal" class="page-main journal-main">
	<section class="journal-intro journal-intro--blog">
		<div class="container journal-intro__inner">
			<div class="journal-intro__copy" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Blog', 'tema-carolina' ); ?></span>
				<h1 class="archive-title"><?php echo esc_html( $blog_title ); ?></h1>
				<p class="journal-intro__lead"><?php echo esc_html( $blog_intro ); ?></p>
				<div class="journal-intro__actions">
					<a class="btn btn-primary" href="#lista-artigos"><?php esc_html_e( 'Explorar artigos', 'tema-carolina' ); ?></a>
					<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_main_site_section_url( 'agendar' ) ); ?>"><?php esc_html_e( 'Agendar sessão', 'tema-carolina' ); ?></a>
				</div>
			</div>
			<div class="journal-intro__aside" data-reveal>
				<p class="journal-intro__note"><?php esc_html_e( 'Textos pensados para acolher, informar e aprofundar conversas sobre relações, ansiedade, presença e processo terapêutico.', 'tema-carolina' ); ?></p>
			</div>
		</div>
	</section>

	<section class="journal-search-section" aria-labelledby="blog-search-title">
		<div class="container">
			<div class="journal-search-card" data-reveal>
				<div class="journal-search-card__content">
					<span class="eyebrow"><?php esc_html_e( 'Busca', 'tema-carolina' ); ?></span>
					<h2 id="blog-search-title"><?php esc_html_e( 'Encontre um artigo pelo tema que você quer explorar', 'tema-carolina' ); ?></h2>
					<p><?php esc_html_e( 'Pesquise por uma palavra-chave para localizar textos sobre terapia, vínculos, ansiedade, autoconhecimento e outros assuntos do blog.', 'tema-carolina' ); ?></p>
				</div>
				<?php get_search_form(); ?>
			</div>
		</div>
	</section>

	<?php if ( $categories ) : ?>
		<section class="journal-intro" id="temas">
			<div class="container">
				<div class="journal-intro__copy" data-reveal>
					<span class="eyebrow"><?php esc_html_e( 'Temas', 'tema-carolina' ); ?></span>
					<h2><?php esc_html_e( 'Navegue por categorias do blog', 'tema-carolina' ); ?></h2>
					<p class="journal-intro__lead"><?php esc_html_e( 'Os conteúdos do blog também ficam organizados por temas nativos do WordPress, facilitando encontrar reflexões sobre assuntos específicos.', 'tema-carolina' ); ?></p>
					<?php
					tema_carolina_render_editorial_topic_navigation(
						array(
							'nav_class'           => 'journal-intro__actions entry-taxonomy entry-taxonomy--topics',
							'current_category_id' => 0,
							'active_all'          => true,
						)
					);
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="journal-listing" id="lista-artigos">
		<div class="container">
			<div class="journal-preview-header section-heading" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Posts recentes', 'tema-carolina' ); ?></span>
				<div class="journal-preview-header__row">
					<div>
						<h2><?php esc_html_e( 'Últimos artigos publicados no blog', 'tema-carolina' ); ?></h2>
						<p><?php esc_html_e( 'Uma seleção dos textos mais recentes para você continuar essa conversa com calma, profundidade e acolhimento.', 'tema-carolina' ); ?></p>
					</div>
					<?php if ( $categories ) : ?>
						<a class="text-link journal-preview-link" href="#temas"><?php esc_html_e( 'Navegar por temas', 'tema-carolina' ); ?></a>
					<?php endif; ?>
				</div>
			</div>

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
