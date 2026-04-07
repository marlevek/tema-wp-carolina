<?php
/**
 * Cabeçalho do tema.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#conteudo-principal"><?php esc_html_e( 'Pular para o conteúdo principal', 'tema-carolina' ); ?></a>

<div class="cursor-ring" aria-hidden="true"></div>

<a
	class="floating-whatsapp"
	href="<?php echo esc_url( tema_carolina_get_whatsapp_url() ); ?>"
	target="_blank"
	rel="noopener noreferrer"
	aria-label="<?php esc_attr_e( 'Agende sua sessão pelo WhatsApp', 'tema-carolina' ); ?>"
>
	<span class="floating-whatsapp-dot" aria-hidden="true"></span>
	<span class="floating-whatsapp-label"><?php esc_html_e( 'Agende sua sessão', 'tema-carolina' ); ?></span>
</a>

<header class="site-header">
	<div class="container header-inner">
		<div class="brand-block">
			<?php get_template_part( 'template-parts/site', 'branding' ); ?>
		</div>

		<div class="header-nav-wrap">
			<nav class="top-nav" aria-label="<?php esc_attr_e( 'Navegação do blog', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_blog_primary_menu( 'top-nav__list' ); ?>
			</nav>
		</div>

		<button
			class="nav-toggle"
			type="button"
			aria-expanded="false"
			aria-controls="mobile-menu"
			aria-label="<?php esc_attr_e( 'Abrir menu de navegação', 'tema-carolina' ); ?>"
		>
			<span></span>
			<span></span>
			<span></span>
		</button>
	</div>

	<div class="mobile-nav-panel" id="mobile-menu" hidden>
		<div class="container mobile-nav-panel__inner">
			<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Navegação mobile do blog', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_blog_primary_menu( 'mobile-nav__list' ); ?>
			</nav>
			<div class="mobile-nav-footer">
				<a class="mobile-nav-contact" href="<?php echo esc_url( tema_carolina_get_whatsapp_url() ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Agendar pelo WhatsApp', 'tema-carolina' ); ?>
				</a>
			</div>
		</div>
	</div>
</header>
