<?php
/**
 * Bloco de identidade visual do cabeçalho.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo_markup    = '';

if ( $custom_logo_id ) {
	$logo_markup = wp_get_attachment_image(
		$custom_logo_id,
		'full',
		false,
		array(
			'class'    => 'brand-logo',
			'loading'  => 'eager',
			'decoding' => 'async',
		)
	);
}
?>
<a class="brand-link" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>" aria-label="<?php esc_attr_e( 'Voltar para a página inicial do blog', 'tema-carolina' ); ?>">
	<?php echo wp_kses_post( $logo_markup ); ?>
	<span class="brand-text">
		<span class="eyebrow">Psicóloga</span>
		<span class="brand-name">Carolina Cunha Levek</span>
		<span class="brand-crp">CRP 08/48278</span>
	</span>
</a>
