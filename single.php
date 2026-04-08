<?php
/**
 * Template de post individual.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id       = (int) get_queried_object_id();
$related_posts = tema_carolina_get_related_posts_query( $post_id, 3 );

get_header();
?>

<main id="conteudo-principal" class="page-main page-main--single">
	<div class="entry-shell entry-shell--single">
		<?php tema_carolina_render_breadcrumbs(); ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'single' );
		endwhile;
		?>

		<?php if ( $related_posts->have_posts() ) : ?>
			<section class="related-posts" aria-labelledby="related-posts-title" data-reveal>
				<div class="related-posts__header">
					<span class="eyebrow"><?php esc_html_e( 'Continue lendo', 'tema-carolina' ); ?></span>
					<h2 id="related-posts-title"><?php esc_html_e( 'Outros textos para aprofundar essa conversa', 'tema-carolina' ); ?></h2>
					<p><?php esc_html_e( 'Uma seleção de artigos próximos deste tema para sustentar a leitura com mais contexto e continuidade.', 'tema-carolina' ); ?></p>
				</div>
				<div class="posts-grid posts-grid--journal">
					<?php
					while ( $related_posts->have_posts() ) :
						$related_posts->the_post();
						get_template_part( 'template-parts/content', 'archive' );
					endwhile;
					?>
				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegação entre artigos', 'tema-carolina' ); ?>" data-reveal>
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="post-navigation__label">' . esc_html__( 'Artigo anterior', 'tema-carolina' ) . '</span><span class="post-navigation__title">%title</span>',
					'next_text' => '<span class="post-navigation__label">' . esc_html__( 'Próximo artigo', 'tema-carolina' ) . '</span><span class="post-navigation__title">%title</span>',
				)
			);
			?>
		</nav>

		<section class="entry-cta" data-reveal>
			<p class="entry-cta__eyebrow"><?php esc_html_e( 'Continuar navegando', 'tema-carolina' ); ?></p>
			<h2><?php esc_html_e( 'Quer seguir lendo ou marcar sua primeira conversa?', 'tema-carolina' ); ?></h2>
			<div class="entry-cta__actions">
				<a class="btn btn-primary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>"><?php esc_html_e( 'Voltar para o blog', 'tema-carolina' ); ?></a>
				<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_main_site_section_url( 'agendar' ) ); ?>"><?php esc_html_e( 'Agendar sessão', 'tema-carolina' ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
