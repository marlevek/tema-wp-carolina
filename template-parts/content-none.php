<?php
/**
 * Conteúdo exibido quando não há resultados.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="not-found-card" data-reveal>
	<span class="eyebrow"><?php esc_html_e( 'Conteúdo', 'tema-carolina' ); ?></span>
	<h2 class="entry-title"><?php esc_html_e( 'Nenhum conteúdo foi encontrado.', 'tema-carolina' ); ?></h2>
	<p><?php esc_html_e( 'Assim que novas páginas ou posts forem publicados, eles aparecerão aqui.', 'tema-carolina' ); ?></p>
	<p>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Voltar para o início', 'tema-carolina' ); ?>
		</a>
	</p>
</section>
