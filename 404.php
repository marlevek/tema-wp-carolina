<?php
/**
 * Template 404.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo-principal" class="page-main">
	<div class="entry-shell">
		<section class="not-found-card" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Página não encontrada', 'tema-carolina' ); ?></span>
			<h1 class="entry-title"><?php esc_html_e( 'Esse caminho não existe ou foi movido.', 'tema-carolina' ); ?></h1>
			<p><?php esc_html_e( 'Você pode voltar para a página inicial, acessar o blog ou seguir para o agendamento.', 'tema-carolina' ); ?></p>
			<p class="not-found-card__actions">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Voltar para o início', 'tema-carolina' ); ?>
				</a>
				<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>">
					<?php esc_html_e( 'Ir para o blog', 'tema-carolina' ); ?>
				</a>
			</p>
		</section>
	</div>
</main>

<?php
get_footer();
