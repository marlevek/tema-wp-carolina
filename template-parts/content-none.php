<?php
/**
 * Conteúdo exibido quando não há resultados.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_search = is_search();
?>
<section class="not-found-card" data-reveal>
	<span class="eyebrow"><?php echo esc_html( $is_search ? __( 'Busca', 'tema-carolina' ) : __( 'Conteúdo', 'tema-carolina' ) ); ?></span>
	<h2 class="entry-title">
		<?php echo esc_html( $is_search ? __( 'Nenhum artigo correspondeu à sua busca.', 'tema-carolina' ) : __( 'Nenhum conteúdo foi encontrado.', 'tema-carolina' ) ); ?>
	</h2>
	<p>
		<?php
		echo esc_html(
			$is_search
				? __( 'Tente ajustar os termos pesquisados ou explorar os artigos mais recentes do blog.', 'tema-carolina' )
				: __( 'Assim que novas páginas ou posts forem publicados, eles aparecerão aqui.', 'tema-carolina' )
		);
		?>
	</p>
	<?php if ( $is_search ) : ?>
		<div class="not-found-card__search">
			<?php get_search_form(); ?>
		</div>
		<div class="not-found-card__actions">
			<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>">
				<?php esc_html_e( 'Ver todos os artigos', 'tema-carolina' ); ?>
			</a>
		</div>
	<?php else : ?>
		<div class="not-found-card__actions">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Voltar para o início', 'tema-carolina' ); ?>
			</a>
		</div>
	<?php endif; ?>
</section>
