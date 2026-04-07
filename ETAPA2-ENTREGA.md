# Etapa 2 - Conteúdo completo dos arquivos alterados

## style.css

```css
/*
Theme Name: Tema Carolina
Theme URI: https://carolinacunhalevek.com.br/
Author: Codertec
Author URI: https://codertec.com.br/
Description: Tema WordPress customizado para a psicÃ³loga Carolina Cunha Levek, baseado na identidade visual do site institucional original.
Version: 1.0.0
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.1
Text Domain: tema-carolina
*/

.screen-reader-text {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

.screen-reader-text:focus {
  clip: auto;
  width: auto;
  height: auto;
  margin: 0;
  padding: 0.75rem 1rem;
  inset: 1rem auto auto 1rem;
  overflow: visible;
  background: #ffffff;
  color: #2e2438;
  z-index: 9999;
}
```

## functions.php

```php
<?php
/**
 * FunÃ§Ãµes principais do tema Carolina.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ConfiguraÃ§Ã£o base do tema.
 */
function tema_carolina_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 96,
			'width'       => 96,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	add_image_size( 'tema-carolina-card', 760, 520, true );

	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'tema-carolina' ),
			'footer'  => __( 'Menu do rodapÃ©', 'tema-carolina' ),
		)
	);
}
add_action( 'after_setup_theme', 'tema_carolina_setup' );

/**
 * Habilita resumo em pÃ¡ginas para introduÃ§Ãµes editoriais.
 */
function tema_carolina_enable_page_excerpt() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'tema_carolina_enable_page_excerpt' );

/**
 * URL das fontes do tema.
 *
 * @return string
 */
function tema_carolina_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@400;500;700&display=swap';
}

/**
 * Melhora o carregamento das fontes externas.
 *
 * @param array  $urls Lista de URLs.
 * @param string $relation_type Tipo de relation.
 * @return array
 */
function tema_carolina_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}

	$urls[] = 'https://fonts.googleapis.com';
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);

	return $urls;
}
add_filter( 'wp_resource_hints', 'tema_carolina_resource_hints', 10, 2 );

/**
 * Enfileira CSS e JS do tema.
 */
function tema_carolina_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$main_css_path = get_theme_file_path( '/assets/css/main.css' );
	$main_js_path  = get_theme_file_path( '/assets/js/theme.js' );

	wp_enqueue_style( 'tema-carolina-fonts', tema_carolina_fonts_url(), array(), null );
	wp_enqueue_style( 'tema-carolina-style', get_stylesheet_uri(), array(), $theme_version );
	wp_enqueue_style(
		'tema-carolina-main',
		get_theme_file_uri( '/assets/css/main.css' ),
		array( 'tema-carolina-fonts', 'tema-carolina-style' ),
		file_exists( $main_css_path ) ? (string) filemtime( $main_css_path ) : $theme_version
	);

	wp_enqueue_script(
		'tema-carolina-theme',
		get_theme_file_uri( '/assets/js/theme.js' ),
		array(),
		file_exists( $main_js_path ) ? (string) filemtime( $main_js_path ) : $theme_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'tema_carolina_enqueue_assets' );

/**
 * Ajusta o comprimento padrÃ£o do excerpt.
 *
 * @param int $length Comprimento original.
 * @return int
 */
function tema_carolina_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}

	return 24;
}
add_filter( 'excerpt_length', 'tema_carolina_excerpt_length', 999 );

/**
 * Ajusta o final do excerpt.
 *
 * @param string $more Final original.
 * @return string
 */
function tema_carolina_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return '...';
}
add_filter( 'excerpt_more', 'tema_carolina_excerpt_more' );

/**
 * Retorna a URL de uma seÃ§Ã£o da home.
 *
 * @param string $section_id ID da seÃ§Ã£o.
 * @return string
 */
function tema_carolina_get_section_url( $section_id ) {
	$section_id = ltrim( (string) $section_id, '#' );
	$anchor     = '#' . $section_id;

	if ( is_front_page() ) {
		return $anchor;
	}

	return home_url( '/' ) . $anchor;
}

/**
 * Retorna a URL da pÃ¡gina de blog.
 *
 * @return string
 */
function tema_carolina_get_blog_url() {
	$page_for_posts = (int) get_option( 'page_for_posts' );

	if ( $page_for_posts ) {
		$permalink = get_permalink( $page_for_posts );

		if ( $permalink ) {
			return $permalink;
		}
	}

	return home_url( '/blog/' );
}

/**
 * Monta a URL do WhatsApp.
 *
 * @param string $message Mensagem inicial.
 * @return string
 */
function tema_carolina_get_whatsapp_url( $message = '' ) {
	$base_url = 'https://wa.me/5541984863376';

	if ( '' === $message ) {
		$message = 'OlÃ¡, Carol! Gostaria de agendar minha primeira sessÃ£o.';
	}

	return $base_url . '?text=' . rawurlencode( $message );
}

/**
 * Fallback do menu principal.
 *
 * @return array<int, array<string, string>>
 */
function tema_carolina_get_primary_fallback_items() {
	return array(
		array(
			'label' => __( 'InÃ­cio', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'inicio' ),
		),
		array(
			'label' => __( 'Sobre a terapia', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'sobre-a-terapia' ),
		),
		array(
			'label' => __( 'Sobre mim', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'sobre-mim' ),
		),
		array(
			'label' => __( 'Como funciona', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'como-funciona' ),
		),
		array(
			'label' => __( 'Blog', 'tema-carolina' ),
			'url'   => tema_carolina_get_blog_url(),
		),
		array(
			'label' => __( 'Agendar', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'agendar' ),
		),
	);
}

/**
 * Fallback do menu de rodapÃ©.
 *
 * @return array<int, array<string, string>>
 */
function tema_carolina_get_footer_fallback_items() {
	return array(
		array(
			'label' => __( 'PÃ¡gina inicial', 'tema-carolina' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'Blog', 'tema-carolina' ),
			'url'   => tema_carolina_get_blog_url(),
		),
		array(
			'label' => __( 'Sobre a terapia', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'sobre-a-terapia' ),
		),
		array(
			'label' => __( 'Agendar sessÃ£o', 'tema-carolina' ),
			'url'   => tema_carolina_get_section_url( 'agendar' ),
		),
	);
}

/**
 * Renderiza uma lista simples de links de fallback.
 *
 * @param array<int, array<string, string>> $items Itens do menu.
 * @param string                            $menu_class Classe da lista.
 */
function tema_carolina_render_fallback_menu( $items, $menu_class ) {
	echo '<ul class="' . esc_attr( $menu_class ) . '">';

	foreach ( $items as $item ) {
		echo '<li class="menu-item">';
		echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		echo '</li>';
	}

	echo '</ul>';
}

/**
 * Renderiza o menu principal.
 *
 * @param string $menu_class Classe da lista.
 */
function tema_carolina_render_primary_menu( $menu_class = 'top-nav__list' ) {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => $menu_class,
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);

		return;
	}

	tema_carolina_render_fallback_menu( tema_carolina_get_primary_fallback_items(), $menu_class );
}

/**
 * Renderiza o menu do rodapÃ©.
 *
 * @param string $menu_class Classe da lista.
 */
function tema_carolina_render_footer_menu( $menu_class = 'footer-nav__list' ) {
	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => $menu_class,
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);

		return;
	}

	tema_carolina_render_fallback_menu( tema_carolina_get_footer_fallback_items(), $menu_class );
}
```

## header.php

```php
<?php
/**
 * CabeÃ§alho do tema.
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

<a class="skip-link screen-reader-text" href="#conteudo-principal"><?php esc_html_e( 'Pular para o conteÃºdo principal', 'tema-carolina' ); ?></a>

<div class="cursor-ring" aria-hidden="true"></div>

<a
	class="floating-whatsapp"
	href="<?php echo esc_url( tema_carolina_get_whatsapp_url() ); ?>"
	target="_blank"
	rel="noopener noreferrer"
	aria-label="<?php esc_attr_e( 'Agende sua sessÃ£o pelo WhatsApp', 'tema-carolina' ); ?>"
>
	<span class="floating-whatsapp-dot" aria-hidden="true"></span>
	<span class="floating-whatsapp-label"><?php esc_html_e( 'Agende sua sessÃ£o', 'tema-carolina' ); ?></span>
</a>

<header class="site-header">
	<div class="container header-inner">
		<div class="brand-block">
			<?php get_template_part( 'template-parts/site', 'branding' ); ?>
		</div>

		<div class="header-nav-wrap">
			<nav class="top-nav" aria-label="<?php esc_attr_e( 'NavegaÃ§Ã£o principal', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_primary_menu( 'top-nav__list' ); ?>
			</nav>
			<span class="nav-crp">CRP 08/48278</span>
		</div>

		<button
			class="nav-toggle"
			type="button"
			aria-expanded="false"
			aria-controls="mobile-menu"
			aria-label="<?php esc_attr_e( 'Abrir menu de navegaÃ§Ã£o', 'tema-carolina' ); ?>"
		>
			<span></span>
			<span></span>
			<span></span>
		</button>
	</div>

	<div class="mobile-nav-panel" id="mobile-menu" hidden>
		<div class="container mobile-nav-panel__inner">
			<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'NavegaÃ§Ã£o mobile', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_primary_menu( 'mobile-nav__list' ); ?>
			</nav>
			<div class="mobile-nav-footer">
				<span class="nav-crp">CRP 08/48278</span>
				<a class="mobile-nav-contact" href="<?php echo esc_url( tema_carolina_get_whatsapp_url() ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Agendar pelo WhatsApp', 'tema-carolina' ); ?>
				</a>
			</div>
		</div>
	</div>
</header>
```

## footer.php

```php
<?php
/**
 * RodapÃ© do tema.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="container footer-inner">
		<div class="footer-branding">
			<p class="footer-title">Carolina Cunha Levek</p>
			<p class="footer-description">PsicÃ³loga | CRP 08/48278</p>
			<p class="footer-description">Atendimento online e presencial em Curitiba, com escuta relacional sistÃªmica e cuidado emocional.</p>
		</div>

		<div class="footer-column">
			<p class="footer-heading"><?php esc_html_e( 'NavegaÃ§Ã£o', 'tema-carolina' ); ?></p>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Links do rodapÃ©', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_footer_menu(); ?>
			</nav>
		</div>

		<div class="footer-column">
			<p class="footer-heading"><?php esc_html_e( 'Contato', 'tema-carolina' ); ?></p>
			<p class="footer-contact-line">Curitiba - PR | Atendimento online e presencial</p>
			<p class="footer-contact-line">
				WhatsApp:
				<a
					class="contact-link"
					href="<?php echo esc_url( tema_carolina_get_whatsapp_url() ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php esc_attr_e( 'Falar com Carolina Cunha Levek no WhatsApp', 'tema-carolina' ); ?>"
				>
					+55 41 98486-3376
				</a>
			</p>
			<a
				class="social-link"
				href="https://www.instagram.com/vinculossinceros/"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Instagram do perfil VÃ­nculos Sinceros', 'tema-carolina' ); ?>"
			>
				<svg viewBox="0 0 24 24" aria-hidden="true">
					<path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9a4.5 4.5 0 0 1-4.5 4.5h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 1.5A3 3 0 0 0 4.5 7.5v9a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-9a3 3 0 0 0-3-3Zm9.75 1.125a1.125 1.125 0 1 1 0 2.25 1.125 1.125 0 0 1 0-2.25ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"></path>
				</svg>
				<span>@vinculossinceros</span>
			</a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

## front-page.php

```php
<?php
/**
 * Template da pÃ¡gina inicial.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri               = get_template_directory_uri();
$photo_png               = $theme_uri . '/assets/img/foto-carolina-cunha-levek.png';
$photo_webp              = $theme_uri . '/assets/img/foto-carolina-cunha-levek.webp';
$hero_whatsapp_message   = 'OlÃ¡, Carol! Gostaria de agendar minha primeira sessÃ£o.';
$cta_whatsapp_message    = 'OlÃ¡, Carol! Gostaria de agendar minha sessÃ£o.';
$agendar_primeira_sessao = tema_carolina_get_whatsapp_url( $hero_whatsapp_message );
$agendar_sessao_direta   = tema_carolina_get_whatsapp_url( $cta_whatsapp_message );
$blog_url                = tema_carolina_get_blog_url();
$recent_posts            = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

get_header();
?>

<main id="conteudo-principal">
	<section class="hero-section" id="inicio">
		<div class="hero-backdrop" aria-hidden="true"></div>
		<div class="container">
			<div class="hero-shell">
				<div class="hero-grid">
					<div class="hero-copy" data-reveal>
						<h1>
							VocÃª sente que estÃ¡ vivendo os mesmos conflitos nas suas
							<span class="hero-highlight">relaÃ§Ãµes</span>?
						</h1>
						<p class="hero-text">
							A terapia pode te ajudar a compreender esses padrÃµes, lidar com a ansiedade e construir vÃ­nculos mais saudÃ¡veis, com atendimento psicolÃ³gico online e presencial em Curitiba.
						</p>
						<div class="hero-actions">
							<a class="btn btn-primary" href="<?php echo esc_url( $agendar_primeira_sessao ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Agendar primeira sessÃ£o', 'tema-carolina' ); ?></a>
							<a class="btn btn-secondary" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Ler artigos', 'tema-carolina' ); ?></a>
						</div>
						<div class="hero-pills" aria-label="<?php esc_attr_e( 'InformaÃ§Ãµes principais', 'tema-carolina' ); ?>">
							<span class="hero-pill"><?php esc_html_e( 'Atendimento online e presencial', 'tema-carolina' ); ?></span>
							<span class="hero-pill"><?php esc_html_e( 'Abordagem relacional sistÃªmica', 'tema-carolina' ); ?></span>
						</div>
					</div>

					<div class="hero-art" data-reveal>
						<div class="hero-photo-stage">
							<div class="hero-photo-card">
								<picture>
									<source srcset="<?php echo esc_url( $photo_webp ); ?>" type="image/webp">
									<img
										class="hero-photo"
										src="<?php echo esc_url( $photo_png ); ?>"
										alt="<?php esc_attr_e( 'Retrato da psicÃ³loga Carolina Cunha Levek', 'tema-carolina' ); ?>"
										width="231"
										height="346"
										loading="eager"
										decoding="async"
										fetchpriority="high"
									>
								</picture>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="section-separator" aria-hidden="true">
		<svg viewBox="0 0 1440 130" preserveAspectRatio="none">
			<path d="M0,48 C196,128 414,146 620,110 C799,80 977,8 1152,16 C1276,22 1362,52 1440,86 L1440,130 L0,130 Z"></path>
		</svg>
	</div>

	<section class="content-section identification-section">
		<div class="container">
			<div class="section-heading" data-reveal>
				<h2>Se relacionar tem sido difÃ­cil <span class="nowrap">para vocÃª?</span></h2>
				<p>Talvez vocÃª esteja passando por isso:</p>
			</div>

			<div class="identification-cards">
				<div class="list-panel identification-panel" data-reveal>
					<ul class="icon-list warm">
						<li>Se sente sobrecarregado emocionalmente.</li>
						<li>Vive conflitos repetitivos nos relacionamentos.</li>
						<li>Tem dificuldade de se posicionar.</li>
						<li>Sente ansiedade ou inseguranÃ§a constante.</li>
						<li>Percebe que algo precisa mudar, mas nÃ£o sabe por onde comeÃ§ar.</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<div class="section-separator reverse" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none">
			<path d="M0,32 C157,92 296,118 516,94 C738,70 889,2 1094,6 C1264,10 1362,56 1440,92 L1440,120 L0,120 Z"></path>
		</svg>
	</div>

	<section class="content-section therapy-section" id="sobre-a-terapia">
		<div class="container split-layout therapy-layout">
			<div class="section-heading therapy-copy" data-reveal>
				<h2>Sobre a terapia</h2>
				<p>A terapia Ã© um espaÃ§o para vocÃª falar sobre o que estÃ¡ vivendo, no seu tempo e do seu jeito. Ao longo da vida, vamos construindo formas de nos relacionar e, muitas vezes, repetimos algumas situaÃ§Ãµes sem perceber. Na terapia, Ã© possÃ­vel olhar para isso com mais clareza, compreender melhor suas emoÃ§Ãµes e encontrar novas formas de lidar com o que sente e com as suas relaÃ§Ãµes.</p>
				<p>Ã‰ tambÃ©m um espaÃ§o de escuta e acolhimento, sem julgamentos, onde vocÃª pode se sentir Ã  vontade para ser quem Ã©.</p>
				<p>NÃ£o Ã© preciso estar â€œno limiteâ€ para buscar ajuda. Muitas pessoas procuram terapia apenas quando jÃ¡ estÃ£o muito sobrecarregadas, mas ela tambÃ©m pode ser um espaÃ§o de prevenÃ§Ã£o, autoconhecimento e desenvolvimento emocional.</p>
				<p>A terapia Ã© um processo construÃ­do a dois. Eu estarei aqui para te acolher e te oferecer ferramentas, e a sua participaÃ§Ã£o e disponibilidade para olhar para si tambÃ©m fazem parte desse caminho.</p>
			</div>

			<aside class="list-panel listening-panel therapy-listening-panel" data-reveal aria-label="<?php esc_attr_e( 'Escuta sistÃªmica', 'tema-carolina' ); ?>">
				<div class="hero-art-copy">
					<span class="art-label"><?php esc_html_e( 'Escuta sistÃªmica', 'tema-carolina' ); ?></span>
					<p class="hero-quote">
						<span class="quote-inline" aria-hidden="true">"</span>VÃ­nculos sinceros comeÃ§am quando vocÃª se encontra com vocÃª mesmo<span class="quote-inline" aria-hidden="true">"</span>
					</p>
					<div class="hero-art-footer">
						<span class="hero-signature">Carolina Levek</span>
					</div>
				</div>
			</aside>
		</div>
	</section>

	<div class="section-separator" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none">
			<path d="M0,72 C148,108 346,126 576,88 C774,56 954,2 1136,10 C1262,16 1352,44 1440,68 L1440,120 L0,120 Z"></path>
		</svg>
	</div>

	<section class="content-section about-section" id="sobre-mim">
		<div class="container about-grid">
			<div class="about-photo-wrap" data-reveal>
				<div class="about-photo-frame">
					<picture>
						<source srcset="<?php echo esc_url( $photo_webp ); ?>" type="image/webp">
						<img
							class="about-photo"
							src="<?php echo esc_url( $photo_png ); ?>"
							alt="<?php esc_attr_e( 'Carolina Cunha Levek em retrato profissional', 'tema-carolina' ); ?>"
							width="231"
							height="346"
							loading="lazy"
							decoding="async"
						>
					</picture>
				</div>
				<p class="photo-note">Carolina Cunha Levek</p>
			</div>

			<div class="about-copy" data-reveal>
				<span class="eyebrow">Sobre mim</span>
				<h2>Oi, eu sou a Carol</h2>
				<p>Sou psicÃ³loga e atuo a partir da abordagem relacional sistÃªmica.</p>
				<p>Acredito que nossas relaÃ§Ãµes sÃ£o espaÃ§os de construÃ§Ã£o, onde emoÃ§Ãµes, histÃ³rias e formas de se relacionar se encontram.</p>
				<p>Na SistÃªmica, olhamos para alÃ©m do indivÃ­duo, considerando tambÃ©m os vÃ­nculos e o contexto em que ele estÃ¡ inserido.</p>
				<p>Isso permite compreender padrÃµes, ressignificar experiÃªncias e construir formas mais saudÃ¡veis de viver.</p>
				<p>Meu trabalho Ã© te ajudar a desenvolver relaÃ§Ãµes mais conscientes, leves e autÃªnticas.</p>
				<p>Porque ser autÃªntico nÃ£o Ã© ser perfeito, Ã© ser inteiro.</p>
				<p class="professional-id">CRP 08/48278</p>
			</div>
		</div>
	</section>

	<div class="section-separator reverse" aria-hidden="true">
		<svg viewBox="0 0 1440 120" preserveAspectRatio="none">
			<path d="M0,36 C174,96 378,126 592,94 C752,70 988,0 1170,18 C1286,30 1370,60 1440,92 L1440,120 L0,120 Z"></path>
		</svg>
	</div>

	<section class="content-section process-section" id="como-funciona">
		<div class="container">
			<div class="section-heading" data-reveal>
				<h2>Como funciona</h2>
			</div>

			<div class="process-grid">
				<article class="mode-card" data-reveal>
					<span class="mode-icon" aria-hidden="true">&#127760;</span>
					<h3>Online</h3>
					<p>Atendimento com a mesma profundidade e acolhimento, onde vocÃª estiver.</p>
				</article>

				<article class="mode-card" data-reveal>
					<span class="mode-icon mode-icon-office" aria-hidden="true">
						<svg viewBox="0 0 24 24" role="img" focusable="false">
							<path d="M5 11V9.5A2.5 2.5 0 0 1 7.5 7h9A2.5 2.5 0 0 1 19 9.5V11"></path>
							<path d="M4 11.5h16v4.5H4z"></path>
							<path d="M6.5 16v2M17.5 16v2"></path>
						</svg>
					</span>
					<h3>Presencial</h3>
					<p>Um espaÃ§o sÃ³ seu, para ser acolhido, se expressar com liberdade e se aproximar de si, com mais clareza, cuidado e sentido.</p>
				</article>
			</div>

			<div class="benefits-note" data-reveal>
				<strong>AtenÃ§Ã£o:</strong> A terapia pode ser um espaÃ§o de cuidado e autoconhecimento, no seu tempo e da sua forma. Ainda assim, nÃ£o posso te garantir resultados, mas certamente alguma transformaÃ§Ã£o acontecerÃ¡, pois cada pessoa vive esse processo de um jeito Ãºnico. Mas vocÃª nÃ£o estÃ¡ sozinho, estou aqui, com disponibilidade para te acolher e te acompanhar ao longo desse processo.
			</div>

			<p class="session-info" data-reveal>Cada processo Ã© Ãºnico e respeita o seu tempo.</p>
		</div>
	</section>

	<div class="section-separator" aria-hidden="true">
		<svg viewBox="0 0 1440 128" preserveAspectRatio="none">
			<path d="M0,60 C158,120 340,130 540,98 C756,64 954,0 1142,8 C1262,12 1360,40 1440,68 L1440,128 L0,128 Z"></path>
		</svg>
	</div>

	<section class="content-section journal-preview-section" id="artigos">
		<div class="container">
			<div class="journal-preview-header section-heading" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Artigos recentes', 'tema-carolina' ); ?></span>
				<div class="journal-preview-header__row">
					<div>
						<h2>ReflexÃµes para te acompanhar tambÃ©m fora da sessÃ£o</h2>
						<p><?php esc_html_e( 'Uma ponte entre o cuidado clÃ­nico e a rotina, com textos sobre vÃ­nculos, emoÃ§Ãµes e relaÃ§Ãµes mais conscientes.', 'tema-carolina' ); ?></p>
					</div>
					<a class="btn btn-secondary" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Ir para o blog', 'tema-carolina' ); ?></a>
				</div>
			</div>

			<?php if ( $recent_posts->have_posts() ) : ?>
				<div class="posts-grid posts-grid--preview">
					<?php
					while ( $recent_posts->have_posts() ) :
						$recent_posts->the_post();
						get_template_part( 'template-parts/content', 'archive' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<div class="not-found-card not-found-card--inline" data-reveal>
					<h2 class="entry-title"><?php esc_html_e( 'O blog estÃ¡ pronto para receber os prÃ³ximos artigos.', 'tema-carolina' ); ?></h2>
					<p><?php esc_html_e( 'Assim que os primeiros textos forem publicados, eles aparecerÃ£o aqui na pÃ¡gina inicial com a mesma identidade visual do restante do site.', 'tema-carolina' ); ?></p>
					<p>
						<a class="btn btn-secondary" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Acessar pÃ¡gina do blog', 'tema-carolina' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="cta-section" id="agendar">
		<div class="container narrow">
			<div class="cta-card" data-reveal>
				<span class="eyebrow light">Primeiro passo</span>
				<h2>Vamos comeÃ§ar?</h2>
				<p class="cta-message">Se vocÃª sente que Ã© o momento de olhar com mais cuidado para si e para suas relaÃ§Ãµes, vocÃª pode comeÃ§ar agora.</p>
				<a class="btn btn-light" href="<?php echo esc_url( $agendar_sessao_direta ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Agendar minha sessÃ£o', 'tema-carolina' ); ?></a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
```

## home.php

```php
<?php
/**
 * PÃ¡gina principal do blog.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$posts_page_id = (int) get_option( 'page_for_posts' );
$blog_title    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog da Carolina', 'tema-carolina' );
$blog_intro    = $posts_page_id ? get_the_excerpt( $posts_page_id ) : '';

if ( ! $blog_intro && $posts_page_id ) {
	$blog_intro = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $posts_page_id ) ), 32 );
}

if ( ! $blog_intro ) {
	$blog_intro = __( 'Um espaÃ§o para reflexÃµes sobre vÃ­nculos, terapia, relaÃ§Ãµes e cuidado emocional, com a mesma delicadeza da experiÃªncia institucional do site.', 'tema-carolina' );
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
					<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_section_url( 'agendar' ) ); ?>"><?php esc_html_e( 'Agendar sessÃ£o', 'tema-carolina' ); ?></a>
				</div>
			</div>
			<div class="journal-intro__aside" data-reveal>
				<p class="journal-intro__note"><?php esc_html_e( 'Textos pensados para acolher, informar e aprofundar conversas sobre relaÃ§Ãµes, ansiedade, presenÃ§a e processo terapÃªutico.', 'tema-carolina' ); ?></p>
			</div>
		</div>
	</section>

	<section class="journal-listing" id="lista-artigos">
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
						'next_text' => __( 'PrÃ³ximos artigos', 'tema-carolina' ),
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
```

## index.php

```php
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
				<span class="eyebrow"><?php esc_html_e( 'ConteÃºdos', 'tema-carolina' ); ?></span>
				<h1 class="archive-title"><?php esc_html_e( 'AtualizaÃ§Ãµes do site', 'tema-carolina' ); ?></h1>
				<p class="journal-intro__lead"><?php esc_html_e( 'Uma visÃ£o geral dos conteÃºdos publicados no tema, com a mesma atmosfera editorial do restante do site.', 'tema-carolina' ); ?></p>
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
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
```

## page.php

```php
<?php
/**
 * Template padrÃ£o para pÃ¡ginas.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo-principal" class="page-main page-main--page">
	<div class="entry-shell">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'page' );
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
```

## single.php

```php
<?php
/**
 * Template de post individual.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="conteudo-principal" class="page-main page-main--single">
	<div class="entry-shell entry-shell--single">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'single' );
		endwhile;
		?>

		<nav class="post-navigation" aria-label="<?php esc_attr_e( 'NavegaÃ§Ã£o entre artigos', 'tema-carolina' ); ?>" data-reveal>
			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="post-navigation__label">' . esc_html__( 'Artigo anterior', 'tema-carolina' ) . '</span><span class="post-navigation__title">%title</span>',
					'next_text' => '<span class="post-navigation__label">' . esc_html__( 'PrÃ³ximo artigo', 'tema-carolina' ) . '</span><span class="post-navigation__title">%title</span>',
				)
			);
			?>
		</nav>

		<section class="entry-cta" data-reveal>
			<p class="entry-cta__eyebrow"><?php esc_html_e( 'Continuar navegando', 'tema-carolina' ); ?></p>
			<h2><?php esc_html_e( 'Quer seguir lendo ou marcar sua primeira conversa?', 'tema-carolina' ); ?></h2>
			<div class="entry-cta__actions">
				<a class="btn btn-primary" href="<?php echo esc_url( tema_carolina_get_blog_url() ); ?>"><?php esc_html_e( 'Voltar para o blog', 'tema-carolina' ); ?></a>
				<a class="btn btn-secondary" href="<?php echo esc_url( tema_carolina_get_section_url( 'agendar' ) ); ?>"><?php esc_html_e( 'Agendar sessÃ£o', 'tema-carolina' ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
```

## archive.php

```php
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
					<p class="journal-intro__lead"><?php esc_html_e( 'ConteÃºdos organizados por tema para facilitar a navegaÃ§Ã£o pelo blog.', 'tema-carolina' ); ?></p>
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
						'next_text' => __( 'PrÃ³ximos artigos', 'tema-carolina' ),
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
```

## 404.php

```php
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
			<span class="eyebrow"><?php esc_html_e( 'PÃ¡gina nÃ£o encontrada', 'tema-carolina' ); ?></span>
			<h1 class="entry-title"><?php esc_html_e( 'Esse caminho nÃ£o existe ou foi movido.', 'tema-carolina' ); ?></h1>
			<p><?php esc_html_e( 'VocÃª pode voltar para a pÃ¡gina inicial, acessar o blog ou seguir para o agendamento.', 'tema-carolina' ); ?></p>
			<p class="not-found-card__actions">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Voltar para o inÃ­cio', 'tema-carolina' ); ?>
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
```

## template-parts\site-branding.php

```php
<?php
/**
 * Bloco de identidade visual do cabeÃ§alho.
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
<a class="brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Voltar para a pÃ¡gina inicial', 'tema-carolina' ); ?>">
	<?php echo wp_kses_post( $logo_markup ); ?>
	<span class="brand-text">
		<span class="eyebrow">PsicÃ³loga</span>
		<span class="brand-name">Carolina Cunha Levek</span>
	</span>
</a>
```

## template-parts\content-none.php

```php
<?php
/**
 * ConteÃºdo exibido quando nÃ£o hÃ¡ resultados.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="not-found-card" data-reveal>
	<span class="eyebrow"><?php esc_html_e( 'ConteÃºdo', 'tema-carolina' ); ?></span>
	<h2 class="entry-title"><?php esc_html_e( 'Nenhum conteÃºdo foi encontrado.', 'tema-carolina' ); ?></h2>
	<p><?php esc_html_e( 'Assim que novas pÃ¡ginas ou posts forem publicados, eles aparecerÃ£o aqui.', 'tema-carolina' ); ?></p>
	<p>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Voltar para o inÃ­cio', 'tema-carolina' ); ?>
		</a>
	</p>
</section>
```

## template-parts\content-archive.php

```php
<?php
/**
 * Card de post para arquivos, blog e destaques.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_the_category_list( '', ', ' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> data-reveal>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="post-card__thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'tema-carolina-card' ); ?>
		</a>
	<?php endif; ?>

	<div class="post-card__content">
		<div class="post-card__meta">
			<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
		</div>

		<h2 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h2>

		<div class="post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<a class="text-link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Ler artigo', 'tema-carolina' ); ?>
		</a>
	</div>
</article>
```

## template-parts\content-single.php

```php
<?php
/**
 * ConteÃºdo individual de post.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_the_category_list( '', ', ' );
$tags       = get_the_tag_list( '', '' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card--single' ); ?> data-reveal>
	<header class="entry-header entry-header--single">
		<div class="entry-header__meta">
			<time class="entry-meta" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<?php if ( $categories ) : ?>
				<div class="entry-taxonomy"><?php echo wp_kses_post( $categories ); ?></div>
			<?php endif; ?>
		</div>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="entry-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail entry-thumbnail--single">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php if ( $tags ) : ?>
		<footer class="entry-footer">
			<p class="footer-heading"><?php esc_html_e( 'Temas do artigo', 'tema-carolina' ); ?></p>
			<div class="entry-taxonomy entry-taxonomy--tags"><?php echo wp_kses_post( $tags ); ?></div>
		</footer>
	<?php endif; ?>
</article>
```

## template-parts\content-page.php

```php
<?php
/**
 * ConteÃºdo padrÃ£o de pÃ¡gina.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card entry-card--page' ); ?> data-reveal>
	<header class="entry-header">
		<span class="eyebrow"><?php esc_html_e( 'PÃ¡gina', 'tema-carolina' ); ?></span>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p class="entry-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
```

## assets\js\theme.js

```js
(function () {
  const root = document.documentElement;
  const cursor = document.querySelector(".cursor-ring");
  const heroBackdrop = document.querySelector(".hero-backdrop");
  const revealItems = document.querySelectorAll("[data-reveal]");
  const navToggle = document.querySelector(".nav-toggle");
  const mobileMenu = document.querySelector("#mobile-menu");
  const mobileLinks = document.querySelectorAll(".mobile-nav a");
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const coarsePointer = window.matchMedia("(pointer: coarse)").matches;

  if (navToggle && mobileMenu) {
    const closeMenu = function () {
      navToggle.setAttribute("aria-expanded", "false");
      mobileMenu.hidden = true;
      document.body.classList.remove("menu-open");
    };

    navToggle.addEventListener("click", function () {
      const isOpen = navToggle.getAttribute("aria-expanded") === "true";
      navToggle.setAttribute("aria-expanded", String(!isOpen));
      mobileMenu.hidden = isOpen;
      document.body.classList.toggle("menu-open", !isOpen);
    });

    mobileLinks.forEach(function (link) {
      link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeMenu();
      }
    });

    document.addEventListener("click", function (event) {
      const isOpen = navToggle.getAttribute("aria-expanded") === "true";

      if (!isOpen) {
        return;
      }

      const clickedInsideMenu = mobileMenu.contains(event.target);
      const clickedToggle = navToggle.contains(event.target);

      if (!clickedInsideMenu && !clickedToggle) {
        closeMenu();
      }
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth > 960) {
        closeMenu();
      }
    });
  }

  if (!coarsePointer && !reducedMotion && cursor) {
    let cursorX = window.innerWidth / 2;
    let cursorY = window.innerHeight / 2;
    let currentX = cursorX;
    let currentY = cursorY;

    window.addEventListener("mousemove", function (event) {
      cursorX = event.clientX;
      cursorY = event.clientY;
      cursor.classList.add("is-active");
    });

    window.addEventListener("mouseleave", function () {
      cursor.classList.remove("is-active");
    });

    const animateCursor = function () {
      currentX += (cursorX - currentX) * 0.18;
      currentY += (cursorY - currentY) * 0.18;
      cursor.style.transform = "translate(" + currentX + "px, " + currentY + "px)";
      window.requestAnimationFrame(animateCursor);
    };

    animateCursor();
  } else if (cursor) {
    cursor.remove();
  }

  if (!reducedMotion && heroBackdrop) {
    let ticking = false;

    const updateParallax = function () {
      const scrollY = window.scrollY || window.pageYOffset;
      root.style.setProperty("--hero-parallax", (scrollY * 0.12).toFixed(2) + "px");
      ticking = false;
    };

    const requestParallaxUpdate = function () {
      if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(updateParallax);
      }
    };

    updateParallax();
    window.addEventListener("scroll", requestParallaxUpdate, { passive: true });
  }

  if ("IntersectionObserver" in window && !reducedMotion) {
    const observer = new IntersectionObserver(function (entries, io) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.16,
      rootMargin: "0px 0px -40px 0px"
    });

    revealItems.forEach(function (item) {
      observer.observe(item);
    });
  } else {
    revealItems.forEach(function (item) {
      item.classList.add("is-visible");
    });
  }
}());
```

## assets\css\main.css

```css
:root {
  --primary: #7B5BA6;
  --accent: #C74B7F;
  --bg: #F6F1FB;
  --surface: #FBF8FD;
  --text: #2E2438;
  --text-soft: #5D4D6E;
  --white: #FFFFFF;
  --line: rgba(46, 36, 56, 0.12);
  --soft-pink: #EBCFE0;
  --bg-main: var(--bg);
  --text-main: var(--text);
  --accent-soft: rgba(199, 75, 127, 0.16);
  --cta: var(--primary);
  --cta-soft: rgba(123, 91, 166, 0.14);
  --surface-strong: #EFE7F7;
  --surface-glass: rgba(251, 248, 253, 0.84);
  --line-strong: rgba(46, 36, 56, 0.18);
  --shadow-soft: 0 28px 60px rgba(46, 36, 56, 0.08);
  --shadow-card: 0 18px 36px rgba(46, 36, 56, 0.08);
  --shadow-hero: 0 34px 72px rgba(46, 36, 56, 0.1);
  --container: 1180px;
  --radius-xl: 44px;
  --radius-lg: 32px;
  --radius-md: 22px;
  --radius-sm: 16px;
  --transition: 220ms ease;
  --hero-parallax: 0px;
}

*,
*::before,
*::after {
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

section[id] {
  scroll-margin-top: 110px;
}

body {
  margin: 0;
  color: var(--text-main);
  font-family: "DM Sans", sans-serif;
  background:
    radial-gradient(circle at 16% 20%, rgba(199, 75, 127, 0.09), transparent 0 24%),
    radial-gradient(circle at 84% 18%, rgba(123, 91, 166, 0.11), transparent 0 19%),
    radial-gradient(circle at 40% 78%, rgba(199, 75, 127, 0.07), transparent 0 20%),
    var(--bg-main);
  line-height: 1.7;
  overflow-x: hidden;
}

body::before,
body::after {
  content: "";
  position: fixed;
  inset: 0;
  pointer-events: none;
}

body::before {
  opacity: 0.2;
  background-image:
    radial-gradient(rgba(46, 36, 56, 0.08) 0.8px, transparent 0.8px),
    radial-gradient(rgba(255, 255, 255, 0.45) 0.9px, transparent 0.9px);
  background-position: 0 0, 12px 10px;
  background-size: 22px 22px, 28px 28px;
  mix-blend-mode: multiply;
}

body::after {
  opacity: 0.26;
  background:
    linear-gradient(90deg, transparent 8%, rgba(46, 36, 56, 0.035) 8.15%, transparent 8.3%),
    linear-gradient(90deg, transparent 91.5%, rgba(46, 36, 56, 0.04) 91.65%, transparent 91.8%);
}

.content-section,
.cta-section,
.site-footer {
  content-visibility: auto;
  contain-intrinsic-size: 720px;
}

::selection {
  background: rgba(199, 75, 127, 0.22);
  color: var(--text-main);
}

a {
  color: inherit;
  text-decoration: none;
}

img {
  display: block;
  max-width: 100%;
}

.nowrap {
  white-space: nowrap;
}

button,
input,
textarea,
select {
  font: inherit;
}

.container {
  width: min(calc(100% - 2rem), var(--container));
  margin: 0 auto;
}

.narrow {
  width: min(calc(100% - 2rem), 860px);
}

.site-header {
  position: sticky;
  top: 0;
  z-index: 40;
  backdrop-filter: blur(18px);
  background: rgba(246, 241, 251, 0.72);
  border-bottom: 1px solid rgba(46, 36, 56, 0.06);
}

.header-inner,
.footer-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
}

.header-inner {
  min-height: 88px;
}

.brand-block,
.footer-inner > div {
  display: grid;
  gap: 0.18rem;
}

.brand-link {
  display: inline-flex;
  align-items: center;
  gap: 0.9rem;
}

.brand-text {
  display: grid;
  gap: 0.18rem;
}

.brand-logo {
  width: 56px;
  height: 56px;
  object-fit: contain;
  flex: 0 0 auto;
}

.brand-name {
  margin: 0;
  display: block;
  font-family: "Cormorant Garamond", serif;
  font-size: 1.7rem;
  font-weight: 600;
  letter-spacing: -0.02em;
  line-height: 0.92;
}

.brand-text .eyebrow {
  margin: 0;
  color: rgba(46, 36, 56, 0.66);
  font-size: 0.68rem;
  letter-spacing: 0.2em;
}

.eyebrow {
  display: inline-block;
  margin: 0 0 0.85rem;
  color: var(--accent);
  font-size: 0.82rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
}

.eyebrow.light {
  color: rgba(255, 255, 255, 0.86);
}

.top-nav {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1.45rem;
  font-size: 0.96rem;
}

.top-nav a,
.mobile-nav a {
  position: relative;
  padding-bottom: 0.2rem;
}

.nav-crp {
  display: inline-flex;
  align-items: center;
  color: rgba(46, 36, 56, 0.72);
  font-size: 0.86rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.top-nav a::after,
.mobile-nav a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 1px;
  background: currentColor;
  transform: scaleX(0);
  transform-origin: left;
  transition: transform var(--transition);
}

.top-nav a:hover::after,
.top-nav a:focus-visible::after,
.mobile-nav a:hover::after,
.mobile-nav a:focus-visible::after {
  transform: scaleX(1);
}

.nav-toggle {
  display: none;
  width: 52px;
  height: 52px;
  padding: 0;
  border: 1px solid rgba(46, 36, 56, 0.14);
  border-radius: 50%;
  background: rgba(251, 248, 253, 0.82);
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 0.28rem;
  cursor: pointer;
}

.nav-toggle span {
  width: 18px;
  height: 1.5px;
  border-radius: 999px;
  background: var(--primary);
  transition: transform var(--transition), opacity var(--transition);
}

.nav-toggle[aria-expanded="true"] span:nth-child(1) {
  transform: translateY(6px) rotate(45deg);
}

.nav-toggle[aria-expanded="true"] span:nth-child(2) {
  opacity: 0;
}

.nav-toggle[aria-expanded="true"] span:nth-child(3) {
  transform: translateY(-6px) rotate(-45deg);
}

.mobile-nav-panel {
  border-top: 1px solid rgba(46, 36, 56, 0.08);
  background: rgba(255, 255, 255, 0.86);
  backdrop-filter: blur(18px);
}

.mobile-nav {
  display: grid;
  gap: 1rem;
  padding-top: 1rem;
  padding-bottom: 1.25rem;
}

.hero-section {
  position: relative;
  padding: 2.2rem 0 4.4rem;
}

.hero-section::after {
  display: none;
}

.hero-backdrop {
  position: absolute;
  inset: 0 0 auto;
  height: 700px;
  pointer-events: none;
  transform: translateY(var(--hero-parallax));
  will-change: transform;
  background:
    radial-gradient(circle at 14% 44%, rgba(199, 75, 127, 0.16), transparent 0 24%),
    radial-gradient(circle at 84% 18%, rgba(123, 91, 166, 0.14), transparent 0 22%),
    radial-gradient(circle at 70% 72%, rgba(199, 75, 127, 0.1), transparent 0 20%),
    linear-gradient(180deg, rgba(255, 255, 255, 0.42), transparent 68%);
}

.hero-shell {
  position: relative;
  z-index: 1;
  overflow: hidden;
  padding: clamp(2rem, 4vw, 3.8rem);
  border: 1px solid rgba(46, 36, 56, 0.08);
  border-radius: clamp(30px, 4vw, 48px);
  background:
    linear-gradient(135deg, rgba(255, 255, 255, 0.7), rgba(251, 248, 253, 0.5) 42%, rgba(239, 231, 247, 0.72)),
    radial-gradient(circle at 20% 24%, rgba(255, 255, 255, 0.7), transparent 42%);
  box-shadow: var(--shadow-hero);
}

.hero-shell::before,
.hero-shell::after {
  content: "";
  position: absolute;
  pointer-events: none;
}

.hero-shell::before {
  inset: 0;
  background:
    radial-gradient(circle at 22% 28%, rgba(199, 75, 127, 0.12), transparent 0 20%),
    radial-gradient(circle at 88% 16%, rgba(123, 91, 166, 0.14), transparent 0 18%),
    radial-gradient(circle at 70% 78%, rgba(235, 207, 224, 0.72), transparent 0 16%);
}

.hero-shell::after {
  inset: 18px;
  border: 1px solid rgba(255, 255, 255, 0.46);
  border-radius: clamp(18px, 3vw, 36px);
  opacity: 0.9;
}

.hero-grid {
  display: grid;
  position: relative;
  z-index: 1;
  grid-template-columns: minmax(0, 1.16fr) minmax(300px, 0.78fr);
  gap: clamp(1rem, 2.4vw, 1.8rem);
  align-items: end;
}

.hero-copy {
  position: relative;
  max-width: 820px;
  padding-right: 0;
}

.hero-copy::before {
  display: none;
}

.hero-copy h1,
.section-heading h2,
.cta-card h2,
.about-copy h2,
.mode-card h3 {
  margin: 0;
  font-family: "Cormorant Garamond", serif;
  font-weight: 400;
  line-height: 1.02;
  letter-spacing: -0.03em;
}

.hero-copy h1 {
  max-width: 14ch;
  font-size: clamp(2.9rem, 5.7vw, 4.85rem);
  font-weight: 600;
  line-height: 0.92;
  text-align: left;
  text-wrap: pretty;
}

.hero-highlight {
  color: var(--accent);
}

.hero-text,
.section-heading p,
.about-copy p,
.mode-card p,
.site-footer p,
.photo-note {
  margin: 0;
  font-size: 1.04rem;
  color: var(--text-soft);
}

.hero-text {
  max-width: 50ch;
  margin-top: 1.35rem;
  font-size: 1.06rem;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  margin-top: 2rem;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 58px;
  padding: 0.95rem 1.55rem;
  border: 1px solid transparent;
  border-radius: 999px;
  font-weight: 700;
  transition:
    transform var(--transition),
    background-color var(--transition),
    color var(--transition),
    border-color var(--transition),
    box-shadow var(--transition);
}

.btn:hover,
.btn:focus-visible,
.floating-whatsapp:hover,
.floating-whatsapp:focus-visible {
  transform: translateY(-2px);
  box-shadow: var(--shadow-card);
}

.btn-primary {
  color: var(--white);
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent),
    linear-gradient(135deg, rgba(123, 91, 166, 1), rgba(199, 75, 127, 0.92));
}

.btn-light {
  color: var(--text-main);
  background: var(--surface);
}

.hero-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 0.85rem;
  margin-top: 2rem;
}

.hero-pill {
  display: inline-flex;
  align-items: center;
  gap: 0.7rem;
  min-height: 3rem;
  padding: 0.75rem 1rem;
  border-radius: 999px;
  border: 1px solid rgba(46, 36, 56, 0.08);
  background: rgba(251, 248, 253, 0.66);
  box-shadow: 0 12px 28px rgba(46, 36, 56, 0.05);
  color: var(--text-main);
  font-size: 0.94rem;
}

.hero-pill::before {
  content: "";
  width: 0.48rem;
  height: 0.48rem;
  border-radius: 50%;
  background: var(--accent);
  box-shadow: 0 0 0 5px rgba(199, 75, 127, 0.12);
}

.hero-pill:nth-child(even)::before {
  background: var(--primary);
  box-shadow: 0 0 0 5px rgba(123, 91, 166, 0.12);
}

.hero-art {
  display: flex;
  justify-content: center;
  align-self: stretch;
}

.hero-photo-stage {
  position: relative;
  width: min(100%, 440px);
  min-height: 100%;
  display: flex;
  align-items: flex-end;
  justify-content: center;
}

@media (min-width: 1100px) {
  .hero-grid {
    grid-template-columns: minmax(0, 1.22fr) minmax(300px, 0.74fr);
    gap: 1rem;
  }

  .hero-copy {
    max-width: 860px;
  }

  .hero-copy h1 {
    max-width: 15ch;
  }

  .hero-photo-stage {
    width: min(100%, 400px);
  }
}

.hero-photo-stage::before,
.hero-photo-stage::after {
  content: "";
  position: absolute;
  border-radius: 999px;
}

.hero-photo-stage::before {
  inset: 10% 10% 14%;
  background:
    radial-gradient(circle at 50% 20%, rgba(255, 255, 255, 0.96), rgba(235, 207, 224, 0.78) 42%, rgba(123, 91, 166, 0.2) 100%);
  filter: blur(3px);
}

.hero-photo-stage::after {
  right: 1rem;
  top: 0.5rem;
  width: 160px;
  height: 160px;
  border: 1px solid rgba(255, 255, 255, 0.65);
}

.hero-photo-card {
  position: relative;
  z-index: 1;
  width: min(100%, 350px);
  padding: 0;
  background: transparent;
  border: 0;
  border-radius: 0;
  box-shadow: none;
  overflow: visible;
}

.hero-photo {
  display: block;
  width: 88%;
  height: auto;
  aspect-ratio: auto;
  margin-inline: auto;
  border-radius: 0;
  background: transparent;
  object-fit: contain;
  object-position: center bottom;
  filter: drop-shadow(0 24px 40px rgba(46, 36, 56, 0.18));
}

.hero-art-copy {
  position: relative;
  z-index: 1;
  display: grid;
  gap: 0.45rem;
  min-width: 0;
  flex: 1;
}

.art-label,
.photo-note {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.art-label {
  color: rgba(46, 36, 56, 0.62);
}

.art-label::before,
.photo-note::before {
  content: "";
  width: 24px;
  height: 1px;
  background: currentColor;
}

.hero-quote {
  margin: 0;
  font-family: "Cormorant Garamond", serif;
  font-style: italic;
}

.hero-quote {
  max-width: none;
  font-size: clamp(1.3rem, 4.5vw, 2.25rem);
  line-height: 1.08;
}

.quote-inline {
  color: var(--text-main);
  font-size: 0.7em;
  line-height: 0;
}

.hero-art-footer {
  display: flex;
  align-items: center;
  margin-top: 0.45rem;
}

.hero-signature {
  display: inline-block;
  font-size: 0.88rem;
  letter-spacing: 0.03em;
}

.content-section,
.cta-section {
  position: relative;
  padding: 2.4rem 0 6rem;
}

.section-heading {
  display: grid;
  gap: 1rem;
}

.section-heading h2,
.cta-card h2,
.about-copy h2 {
  font-size: clamp(2.5rem, 4.6vw, 4.2rem);
  max-width: 24ch;
  text-align: left;
  text-wrap: pretty;
  hyphens: none;
}

.identification-section .section-heading {
  max-width: 980px;
}

.identification-section .section-heading h2 {
  max-width: 30ch;
}

.list-panel,
.mode-card,
.about-copy {
  background: rgba(251, 248, 253, 0.86);
  border: 1px solid rgba(46, 36, 56, 0.08);
  box-shadow: var(--shadow-card);
}

.session-info,
.professional-id {
  margin: 0;
  font-size: 1.06rem;
}

.identification-panel {
  max-width: none;
  margin: 0;
  padding: 2rem;
  border-radius: 28px 28px 74px 28px;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(251, 248, 253, 0.84));
}

.identification-cards {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.2rem;
  margin-top: 1.9rem;
  align-items: stretch;
  max-width: 760px;
}

.listening-panel {
  position: relative;
  display: flex;
  align-items: center;
  padding: 2rem;
  border-radius: 28px 28px 74px 28px;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(251, 248, 253, 0.84));
  overflow: hidden;
}

.therapy-listening-panel {
  width: 100%;
  max-width: none;
  min-height: 300px;
  align-self: center;
  margin-block: auto;
  justify-self: stretch;
  padding: 1.85rem 2.1rem;
  background: linear-gradient(180deg, rgba(234, 194, 211, 0.96), rgba(220, 169, 191, 0.93));
}

.therapy-listening-panel .hero-quote {
  font-size: clamp(1.1rem, 2vw, 1.55rem);
  text-align: justify;
  text-justify: inter-word;
}

.listening-panel .hero-quote {
  font-size: clamp(1.2rem, 2.4vw, 1.85rem);
  line-height: 1.15;
}

.therapy-section {
  padding-top: 3.2rem;
}

.therapy-section .section-heading h2 {
  max-width: 24ch;
}

.split-layout {
  display: grid;
  grid-template-columns: minmax(0, 1fr) minmax(320px, 0.86fr);
  gap: 2.2rem;
  align-items: start;
}

.therapy-section .split-layout {
  position: relative;
  grid-template-columns: minmax(0, 1fr) minmax(450px, 540px);
  gap: 0.45rem;
  align-items: center;
}

.therapy-section .split-layout::before {
  content: "";
  position: absolute;
  inset: -1.25rem 0 -1rem;
  border: 1px solid rgba(46, 36, 56, 0.08);
  border-radius: 34px 34px 80px 34px;
  background: linear-gradient(140deg, rgba(251, 248, 253, 0.56), rgba(239, 231, 247, 0.58));
  z-index: -1;
}

.therapy-copy {
  padding: 1.8rem 1rem 1.8rem 1.6rem;
  max-width: 54ch;
}

.therapy-copy p {
  max-width: none;
  text-align: justify;
  text-justify: inter-word;
  text-wrap: pretty;
}

.icon-list {
  display: grid;
  gap: 1rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.icon-list li {
  position: relative;
  padding-left: 2.2rem;
}

.icon-list li::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0.56rem;
  width: 0.9rem;
  height: 0.9rem;
  border-radius: 999px;
  background: var(--cta);
  box-shadow: 0 0 0 6px rgba(123, 91, 166, 0.12);
}

.icon-list.warm li::before {
  background: var(--accent);
  box-shadow: 0 0 0 6px rgba(235, 207, 224, 0.58);
}

.benefits-note {
  margin: 0.35rem 0 0;
  max-width: 100%;
  padding: 1rem 1.2rem;
  border-left: 3px solid rgba(123, 91, 166, 0.5);
  background: rgba(251, 248, 253, 0.86);
  font-size: 0.98rem;
  color: var(--text-soft);
  text-align: left;
}

.benefits-note strong {
  color: var(--text-main);
}

.about-section {
  padding-top: 3rem;
}

.about-copy h2 {
  max-width: 16ch;
}

.about-grid {
  display: grid;
  grid-template-columns: minmax(320px, 0.94fr) minmax(0, 0.92fr);
  gap: 1.6rem;
  align-items: start;
}

.about-photo-wrap {
  position: relative;
  padding: 1rem 1rem 2rem;
  transform: translateY(-1rem);
}

.about-photo-wrap::before,
.about-photo-wrap::after {
  content: "";
  position: absolute;
}

.about-photo-wrap::before {
  left: 0;
  top: 5%;
  width: 100%;
  height: 88%;
  border: 1px solid rgba(46, 36, 56, 0.1);
  border-radius: 46% 54% 36% 64% / 42% 34% 66% 58%;
  transform: rotate(-4deg);
}

.about-photo-wrap::after {
  right: -1rem;
  bottom: 3rem;
  width: 160px;
  height: 160px;
  border-radius: 62% 38% 52% 48% / 42% 57% 43% 58%;
  background: rgba(235, 207, 224, 0.9);
}

.about-photo-frame {
  position: relative;
  z-index: 1;
  background:
    radial-gradient(circle at 50% 30%, rgba(255, 255, 255, 0.96), rgba(239, 231, 247, 0.6));
  padding: 1.4rem 1rem 0.4rem;
  border-radius: 40% 60% 58% 42% / 32% 38% 62% 68%;
  box-shadow: var(--shadow-soft);
}

.about-photo-frame::before {
  content: "";
  position: absolute;
  inset: 14% 8% 10%;
  border-radius: 42% 58% 40% 60% / 34% 30% 70% 66%;
  background:
    radial-gradient(circle at 50% 22%, rgba(235, 207, 224, 0.9), transparent 58%),
    radial-gradient(circle at 58% 72%, rgba(235, 207, 224, 0.62), transparent 52%);
}

.about-photo {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 460px;
  margin: 0 auto;
  object-fit: contain;
  filter: drop-shadow(0 30px 40px rgba(46, 36, 56, 0.16));
}

.photo-note {
  position: relative;
  z-index: 1;
  margin-top: 1.1rem;
  color: rgba(46, 36, 56, 0.56);
}

.about-copy {
  position: relative;
  display: grid;
  gap: 1rem;
  padding: 2.2rem 2.1rem 2rem;
  border-radius: 26px 26px 72px 26px;
  margin-top: 5rem;
  margin-left: -3.8rem;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(239, 231, 247, 0.78));
}

.about-copy p {
  text-wrap: pretty;
  text-align: justify;
  text-justify: inter-word;
}

.about-copy::before {
  content: "";
  position: absolute;
  left: 2.1rem;
  top: -1.2rem;
  width: 72px;
  height: 1px;
  background: rgba(46, 36, 56, 0.24);
}

.professional-id {
  margin-top: 0.5rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}

.process-section .section-heading {
  max-width: 620px;
}

.process-section .section-heading h2 {
  max-width: 16ch;
}

.process-section .benefits-note {
  margin-top: 1.75rem;
}

.process-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1.2rem;
  margin-top: 2.4rem;
}

.mode-card {
  position: relative;
  padding: 2rem;
  border-radius: 30px 30px 60px 30px;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(239, 231, 247, 0.8));
}

.mode-card::after {
  content: "";
  position: absolute;
  inset: auto 2rem 1.3rem;
  height: 1px;
  background: linear-gradient(to right, rgba(46, 36, 56, 0.18), transparent);
}

.mode-card h3 {
  margin: 0.9rem 0 0.55rem;
  font-size: 2.3rem;
}

.mode-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 4rem;
  height: 4rem;
  font-size: 2rem;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.88);
  border: 1px solid rgba(46, 36, 56, 0.08);
  box-shadow: inset 0 0 0 10px rgba(235, 207, 224, 0.72);
}

.mode-icon svg {
  width: 1.7rem;
  height: 1.7rem;
  stroke: currentColor;
  stroke-width: 1.75;
  stroke-linecap: round;
  stroke-linejoin: round;
  fill: none;
}

.mode-icon {
  color: var(--accent);
}

.mode-icon-office {
  color: #b66a7f;
}

.mode-card:last-child .mode-icon {
  box-shadow: inset 0 0 0 10px rgba(235, 207, 224, 0.56);
}

.session-info {
  margin-top: 1.6rem;
  text-align: center;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.cta-section {
  padding-bottom: 5.2rem;
}

.cta-card h2 {
  max-width: 16ch;
  margin-inline: auto;
  text-align: center;
}

.cta-card {
  position: relative;
  max-width: 760px;
  margin: 0 auto;
  padding: clamp(1.9rem, 3.2vw, 3rem);
  color: var(--white);
  background:
    linear-gradient(155deg, rgba(123, 91, 166, 0.26), transparent),
    linear-gradient(180deg, rgba(255, 255, 255, 0.04), transparent),
    var(--accent);
  border-radius: 42px;
  text-align: center;
  box-shadow: var(--shadow-soft);
  overflow: hidden;
}

.cta-card::before,
.cta-card::after {
  content: "";
  position: absolute;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}

.cta-card::before {
  width: 140px;
  height: 140px;
  right: -32px;
  top: -18px;
}

.cta-card::after {
  width: 96px;
  height: 96px;
  left: -28px;
  bottom: -24px;
}

.cta-card h2 {
  color: var(--white);
}

.cta-message {
  max-width: min(100%, 34rem);
  margin: 1rem auto 1.7rem;
  color: var(--white);
  font-family: "DM Sans", sans-serif;
  font-size: 1.04rem;
  line-height: 1.7;
  text-align: center;
  text-wrap: pretty;
}

.section-separator {
  line-height: 0;
  color: var(--surface);
}

.section-separator svg {
  display: block;
  width: 100%;
  height: 86px;
  fill: currentColor;
}

.section-separator.reverse {
  color: rgba(251, 248, 253, 0.86);
}

.site-footer {
  padding: 1.6rem 0 2.5rem;
}

.floating-whatsapp {
  position: fixed;
  right: 1.15rem;
  bottom: 1.15rem;
  z-index: 45;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.7rem;
  min-height: 58px;
  padding: 0.95rem 1.2rem;
  color: var(--white);
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.08), transparent),
    linear-gradient(135deg, rgba(123, 91, 166, 1), rgba(101, 72, 146, 1));
  border: 1px solid rgba(255, 255, 255, 0.14);
  border-radius: 999px;
  box-shadow: var(--shadow-soft);
  transition: transform var(--transition), box-shadow var(--transition);
}

.floating-whatsapp::before {
  content: "";
  position: absolute;
  inset: 5px;
  border-radius: inherit;
  border: 1px solid rgba(255, 255, 255, 0.08);
  pointer-events: none;
}

.floating-whatsapp-dot {
  width: 0.68rem;
  height: 0.68rem;
  border-radius: 50%;
  background: var(--soft-pink);
  box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.12);
}

.social-link {
  display: inline-flex;
  align-items: center;
  gap: 0.55rem;
  margin-top: 0.7rem;
  color: var(--text-soft);
  transition: color var(--transition), transform var(--transition);
}

.contact-link {
  position: relative;
  display: inline-flex;
  margin-left: 0.35rem;
  color: var(--text-main);
  font-weight: 600;
  transition: color var(--transition);
}

.contact-link::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -0.08rem;
  width: 100%;
  height: 1px;
  background: rgba(199, 75, 127, 0.45);
  transform-origin: left;
  transition: background-color var(--transition), transform var(--transition);
}

.social-link:hover,
.social-link:focus-visible,
.contact-link:hover,
.contact-link:focus-visible {
  color: var(--accent);
  transform: translateY(-1px);
}

.social-link svg {
  width: 1rem;
  height: 1rem;
  fill: currentColor;
}

.floating-whatsapp-label {
  position: relative;
  z-index: 1;
  font-weight: 700;
  letter-spacing: 0.03em;
}

@media (min-width: 1025px) {
  .footer-inner > div:last-child {
    padding-right: 12rem;
  }
}

.cursor-ring {
  position: fixed;
  left: 0;
  top: 0;
  z-index: 50;
  width: 34px;
  height: 34px;
  border: 1px solid rgba(199, 75, 127, 0.65);
  border-radius: 50%;
  pointer-events: none;
  opacity: 0;
  transform: translate(-999px, -999px);
  will-change: transform, opacity;
  transition:
    opacity 180ms ease,
    width 180ms ease,
    height 180ms ease,
    border-color 180ms ease;
}

.cursor-ring.is-active {
  opacity: 1;
}

[data-reveal] {
  opacity: 0;
  transform: translateY(34px);
  will-change: transform, opacity;
  transition:
    opacity 700ms ease,
    transform 700ms ease;
}

[data-reveal].is-visible {
  opacity: 1;
  transform: translateY(0);
}

@media (max-width: 1080px) {
  .about-grid {
    grid-template-columns: 1fr;
  }

  .about-copy {
    margin-top: 0;
    margin-left: 0;
  }

  .about-copy p {
    text-align: justify;
    text-justify: inter-word;
  }
}

@media (max-width: 960px) {
  .hero-grid,
  .split-layout,
  .process-grid {
    grid-template-columns: 1fr;
  }

  .therapy-section .split-layout {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }

  .header-inner {
    min-height: 78px;
  }

  .site-footer {
    padding-bottom: calc(8rem + env(safe-area-inset-bottom, 0px));
  }

  .footer-inner {
    align-items: flex-start;
    flex-direction: column;
  }

  .top-nav {
    display: none;
  }

  .nav-toggle {
    display: inline-flex;
  }

  .hero-copy::before,
  .hero-section::after {
    display: none;
  }

  .hero-copy {
    padding-right: 0;
  }

  .hero-copy h1 {
    max-width: 100%;
    text-align: left;
  }

  .hero-art {
    justify-content: center;
  }

  .hero-shell {
    padding: clamp(1.5rem, 5vw, 2.4rem);
  }

  .hero-pills {
    gap: 0.75rem;
  }

  .hero-photo-stage {
    width: min(100%, 340px);
  }

  .hero-photo-card {
    width: min(100%, 280px);
    margin-inline: auto;
    transform: none;
  }

  .identification-cards {
    grid-template-columns: 1fr;
  }

  .therapy-section .split-layout::before {
    inset: -0.6rem 0 0;
  }

  .therapy-copy {
    max-width: 100%;
    padding: 1.6rem 1rem 0 1.2rem;
  }

  .therapy-listening-panel {
    width: 100%;
    max-width: 100%;
    min-height: auto;
    justify-self: stretch;
  }

  .therapy-copy p {
    text-align: left;
    text-justify: auto;
  }

  .about-photo-wrap {
    transform: none;
  }
}

@media (max-width: 640px) {
  .site-header {
    position: sticky;
    backdrop-filter: blur(12px);
  }

  body.menu-open {
    overflow: hidden;
  }

  body::before,
  body::after {
    display: none;
  }

  .site-footer {
    padding-bottom: calc(8rem + env(safe-area-inset-bottom, 0px));
  }

  .hero-section {
    padding-top: 1.4rem;
    padding-bottom: 3.2rem;
  }

  .hero-backdrop {
    height: 560px;
  }

  .header-inner,
  .footer-inner,
  .hero-actions {
    align-items: flex-start;
    flex-direction: column;
  }

  .nav-toggle {
    align-self: flex-end;
    margin-top: -3.35rem;
  }

  .btn {
    width: 100%;
  }

  .hero-shell::after {
    inset: 12px;
  }

  .hero-copy h1 {
    font-size: clamp(2.4rem, 11vw, 3.5rem);
  }

  .section-heading h2,
  .cta-card h2,
  .about-copy h2 {
    max-width: 100%;
    hyphens: none;
  }

  .hero-pills {
    gap: 0.7rem;
  }

  .hero-pill {
    width: 100%;
    justify-content: flex-start;
  }

  .hero-photo-stage {
    width: min(100%, 275px);
  }

  .hero-photo-card {
    width: min(100%, 230px);
  }

  .mode-card,
  .list-panel,
  .cta-card,
  .about-copy {
    border-radius: 24px;
  }

  .hero-quote {
    text-wrap: balance;
  }

  .therapy-copy {
    padding-inline: 0.85rem;
  }

  .therapy-copy p {
    font-size: 1rem;
    line-height: 1.75;
  }

  .therapy-listening-panel {
    padding: 1.5rem;
  }

  .therapy-listening-panel .hero-quote {
    font-size: 1.2rem;
    text-align: left;
    text-justify: auto;
  }

  .floating-whatsapp {
    right: 1rem;
    bottom: calc(1rem + env(safe-area-inset-bottom, 0px));
    width: auto;
    max-width: calc(100% - 2rem);
    min-height: 54px;
    padding: 0.85rem 1rem;
  }

  .floating-whatsapp-label {
    font-size: 0.95rem;
  }
}

@media (prefers-reduced-motion: reduce) {
  html {
    scroll-behavior: auto;
  }

  *,
  *::before,
  *::after {
    animation: none !important;
    transition: none !important;
  }

  [data-reveal] {
    opacity: 1;
    transform: none;
  }
}

@media (pointer: coarse) {
  .cursor-ring {
    display: none;
  }
}

body.admin-bar .site-header {
  top: 32px;
}

@media (max-width: 782px) {
  body.admin-bar .site-header {
    top: 46px;
  }
}

.top-nav__list,
.mobile-nav__list {
  margin: 0;
  padding: 0;
  list-style: none;
}

.top-nav__list {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 1.45rem;
}

.mobile-nav__list {
  display: grid;
  gap: 1rem;
}

.top-nav .menu-item,
.mobile-nav .menu-item {
  list-style: none;
}

.top-nav .current-menu-item > a::after,
.top-nav .current-menu-ancestor > a::after,
.mobile-nav .current-menu-item > a::after,
.mobile-nav .current-menu-ancestor > a::after {
  transform: scaleX(1);
}

.page-main {
  padding: 2.4rem 0 5.2rem;
}

.entry-shell {
  width: min(calc(100% - 2rem), 920px);
  margin: 0 auto;
}

.entry-card,
.post-card,
.not-found-card,
.archive-header {
  border: 1px solid rgba(46, 36, 56, 0.08);
  box-shadow: var(--shadow-card);
}

.entry-card,
.not-found-card {
  padding: clamp(1.6rem, 3vw, 2.4rem);
  border-radius: 30px;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(239, 231, 247, 0.82));
}

.entry-header {
  display: grid;
  gap: 0.65rem;
  margin-bottom: 1.4rem;
}

.entry-title,
.archive-title,
.post-card__title {
  margin: 0;
  font-family: "Cormorant Garamond", serif;
  letter-spacing: -0.03em;
  line-height: 0.98;
  text-wrap: pretty;
}

.entry-title,
.archive-title {
  font-size: clamp(2.5rem, 5vw, 4.4rem);
}

.post-card__title {
  font-size: clamp(2rem, 4vw, 2.8rem);
}

.archive-header {
  display: grid;
  gap: 0.9rem;
  margin-bottom: 1.8rem;
  padding: clamp(1.5rem, 3vw, 2.2rem);
  border-radius: 30px;
  background: rgba(251, 248, 253, 0.88);
}

.archive-description,
.entry-content,
.post-card__excerpt,
.not-found-card p {
  color: var(--text-soft);
}

.entry-meta {
  margin: 0;
  color: rgba(46, 36, 56, 0.6);
  font-size: 0.92rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.entry-thumbnail,
.post-card__thumb {
  display: block;
  overflow: hidden;
  border-radius: 24px;
}

.entry-thumbnail {
  margin-bottom: 1.5rem;
}

.entry-thumbnail img,
.post-card__thumb img {
  width: 100%;
  height: auto;
}

.entry-content > *:first-child,
.post-card__excerpt > *:first-child {
  margin-top: 0;
}

.entry-content > *:last-child,
.post-card__excerpt > *:last-child {
  margin-bottom: 0;
}

.entry-content > * + *,
.post-card__excerpt > * + * {
  margin-top: 1rem;
}

.entry-content a,
.post-card__title a {
  color: inherit;
}

.entry-content ul,
.entry-content ol {
  padding-left: 1.25rem;
}

.posts-grid {
  display: grid;
  gap: 1.5rem;
}

.post-card {
  display: grid;
  overflow: hidden;
  border-radius: 30px;
  background: rgba(251, 248, 253, 0.9);
}

.post-card__content {
  display: grid;
  gap: 0.9rem;
  padding: 1.5rem;
}

.not-found-card .btn {
  width: auto;
}

.posts-navigation {
  margin-top: 2rem;
}

.posts-navigation .nav-links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.8rem;
  justify-content: space-between;
}

.posts-navigation a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 52px;
  padding: 0.8rem 1.2rem;
  border-radius: 999px;
  background: rgba(251, 248, 253, 0.92);
  border: 1px solid rgba(46, 36, 56, 0.08);
}

@media (max-width: 960px) {
  .top-nav__list {
    gap: 1rem;
  }
}

@media (max-width: 640px) {
  .entry-card,
  .post-card,
  .not-found-card,
  .archive-header {
    border-radius: 24px;
  }

  .post-card__content {
    padding: 1.25rem;
  }

  .posts-navigation .nav-links {
    flex-direction: column;
  }
}

/* Etapa 2: navegaÃ§Ã£o, blog, pÃ¡ginas e leitura */

.btn-secondary {
  color: var(--text-main);
  border-color: rgba(46, 36, 56, 0.12);
  background: rgba(251, 248, 253, 0.72);
}

.header-nav-wrap {
  display: flex;
  align-items: center;
  gap: 1.4rem;
}

.top-nav__list a,
.mobile-nav__list a,
.footer-nav__list a,
.entry-taxonomy a,
.text-link {
  transition: color var(--transition), opacity var(--transition), transform var(--transition);
}

.mobile-nav-panel__inner {
  display: grid;
  gap: 1.15rem;
  padding-top: 1rem;
  padding-bottom: 1.25rem;
}

.mobile-nav {
  display: block;
}

.mobile-nav-footer {
  display: grid;
  gap: 0.8rem;
  padding-top: 0.3rem;
}

.mobile-nav-contact,
.text-link {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--accent);
  font-weight: 700;
}

.text-link::after {
  content: "â†’";
  transition: transform var(--transition);
}

.text-link:hover::after,
.text-link:focus-visible::after {
  transform: translateX(4px);
}

.journal-main {
  padding-top: 1.8rem;
}

.journal-intro {
  padding: 0 0 2.4rem;
}

.journal-intro__inner {
  display: grid;
  grid-template-columns: minmax(0, 1.15fr) minmax(240px, 0.55fr);
  gap: 1.4rem;
  align-items: stretch;
}

.journal-intro__copy,
.journal-intro__aside {
  border: 1px solid rgba(46, 36, 56, 0.08);
  box-shadow: var(--shadow-card);
}

.journal-intro__copy {
  padding: clamp(1.6rem, 3vw, 2.5rem);
  border-radius: 34px 34px 76px 34px;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(239, 231, 247, 0.84));
}

.journal-intro__copy .archive-title {
  margin-bottom: 0.9rem;
}

.journal-intro__lead {
  margin: 0;
  max-width: 58ch;
  font-size: 1.06rem;
  color: var(--text-soft);
}

.journal-intro__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.9rem;
  margin-top: 1.6rem;
}

.journal-intro__aside {
  display: flex;
  align-items: flex-end;
  justify-content: center;
  padding: clamp(1.35rem, 3vw, 2rem);
  border-radius: 28px;
  background:
    radial-gradient(circle at top right, rgba(235, 207, 224, 0.92), transparent 48%),
    linear-gradient(160deg, rgba(251, 248, 253, 0.94), rgba(239, 231, 247, 0.84));
}

.journal-intro__note {
  margin: 0;
  max-width: 26ch;
  font-family: "Cormorant Garamond", serif;
  font-size: clamp(1.5rem, 2.8vw, 2.15rem);
  line-height: 1.08;
  color: var(--text-main);
}

.journal-listing {
  padding-bottom: 2rem;
}

.posts-grid--journal,
.posts-grid--preview {
  grid-template-columns: repeat(3, minmax(0, 1fr));
  align-items: start;
}

.journal-preview-section {
  padding-top: 2.8rem;
}

.journal-preview-header {
  margin-bottom: 2rem;
}

.journal-preview-header__row {
  display: flex;
  align-items: end;
  justify-content: space-between;
  gap: 1rem;
}

.journal-preview-header__row h2 {
  max-width: 18ch;
}

.post-card__meta {
  display: grid;
  gap: 0.75rem;
}

.entry-taxonomy {
  display: flex;
  flex-wrap: wrap;
  gap: 0.55rem;
}

.entry-taxonomy a {
  display: inline-flex;
  align-items: center;
  min-height: 2rem;
  padding: 0.35rem 0.8rem;
  border-radius: 999px;
  background: rgba(199, 75, 127, 0.08);
  color: var(--accent);
  font-size: 0.82rem;
  font-weight: 700;
}

.entry-taxonomy--tags a {
  background: rgba(123, 91, 166, 0.08);
  color: var(--primary);
}

.entry-intro {
  margin: 0;
  max-width: 52ch;
  font-size: 1.12rem;
  color: var(--text-soft);
}

.entry-shell--single {
  width: min(calc(100% - 2rem), 860px);
}

.entry-card--single,
.entry-card--page {
  padding: clamp(1.8rem, 4vw, 3rem);
}

.entry-header--single {
  gap: 0.95rem;
}

.entry-header__meta {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.8rem;
}

.entry-thumbnail--single {
  margin-bottom: 2rem;
}

.entry-content {
  font-size: 1.06rem;
  line-height: 1.85;
}

.entry-content h2,
.entry-content h3,
.entry-content h4 {
  margin-bottom: 0;
  font-family: "Cormorant Garamond", serif;
  line-height: 1.02;
  letter-spacing: -0.03em;
  color: var(--text-main);
}

.entry-content h2 {
  font-size: clamp(2rem, 3.5vw, 3rem);
}

.entry-content h3 {
  font-size: clamp(1.7rem, 3vw, 2.3rem);
}

.entry-content blockquote {
  margin: 2rem 0;
  padding: 1.6rem 1.8rem;
  border-left: 3px solid rgba(199, 75, 127, 0.45);
  border-radius: 24px;
  background: rgba(251, 248, 253, 0.88);
  font-family: "Cormorant Garamond", serif;
  font-size: 1.55rem;
  line-height: 1.2;
  color: var(--text-main);
}

.entry-content figure {
  margin: 2rem 0;
}

.entry-content figcaption,
.wp-caption-text {
  margin-top: 0.75rem;
  font-size: 0.92rem;
  color: rgba(46, 36, 56, 0.62);
  text-align: center;
}

.entry-content img {
  border-radius: 24px;
}

.entry-content a {
  color: var(--accent);
  text-decoration: underline;
  text-decoration-color: rgba(199, 75, 127, 0.35);
  text-underline-offset: 0.18rem;
}

.entry-content strong {
  color: var(--text-main);
}

.entry-footer {
  margin-top: 2rem;
  padding-top: 1.2rem;
  border-top: 1px solid rgba(46, 36, 56, 0.08);
}

.post-navigation {
  margin-top: 1.5rem;
}

.post-navigation .nav-links {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
}

.post-navigation .nav-previous,
.post-navigation .nav-next {
  min-width: 0;
}

.post-navigation a {
  display: grid;
  gap: 0.35rem;
  padding: 1.2rem 1.25rem;
  border-radius: 24px;
  border: 1px solid rgba(46, 36, 56, 0.08);
  background: rgba(251, 248, 253, 0.88);
  box-shadow: var(--shadow-card);
}

.post-navigation__label {
  color: rgba(46, 36, 56, 0.62);
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.post-navigation__title {
  font-family: "Cormorant Garamond", serif;
  font-size: 1.5rem;
  line-height: 1.08;
}

.entry-cta {
  margin-top: 1.5rem;
  padding: 1.6rem;
  border-radius: 28px;
  background:
    linear-gradient(155deg, rgba(123, 91, 166, 0.16), transparent),
    rgba(251, 248, 253, 0.92);
  border: 1px solid rgba(46, 36, 56, 0.08);
  box-shadow: var(--shadow-card);
}

.entry-cta__eyebrow {
  margin: 0 0 0.4rem;
  color: var(--accent);
  font-size: 0.82rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
}

.entry-cta h2 {
  margin: 0;
  font-family: "Cormorant Garamond", serif;
  font-size: clamp(2rem, 4vw, 3rem);
  line-height: 1.02;
}

.entry-cta__actions,
.not-found-card__actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.9rem;
  margin-top: 1.2rem;
}

.pagination {
  margin-top: 2.2rem;
}

.pagination .nav-links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.65rem;
  align-items: center;
}

.page-numbers {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 3rem;
  min-height: 3rem;
  padding: 0.65rem 1rem;
  border-radius: 999px;
  border: 1px solid rgba(46, 36, 56, 0.08);
  background: rgba(251, 248, 253, 0.92);
}

.page-numbers.current {
  background: linear-gradient(135deg, rgba(123, 91, 166, 1), rgba(199, 75, 127, 0.92));
  color: var(--white);
  border-color: transparent;
}

.site-footer {
  padding: 2.5rem 0 2.8rem;
}

.footer-inner {
  display: grid;
  grid-template-columns: minmax(0, 1.1fr) repeat(2, minmax(220px, 0.7fr));
  gap: 1.8rem;
  align-items: start;
}

.footer-branding,
.footer-column {
  display: grid;
  gap: 0.7rem;
}

.footer-title,
.footer-heading {
  margin: 0;
}

.footer-title {
  font-family: "Cormorant Garamond", serif;
  font-size: 2rem;
  line-height: 1;
}

.footer-heading {
  font-size: 0.82rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: var(--accent);
}

.footer-description,
.footer-contact-line {
  margin: 0;
  color: var(--text-soft);
}

.footer-nav__list {
  display: grid;
  gap: 0.65rem;
  margin: 0;
  padding: 0;
  list-style: none;
}

.footer-nav__list .menu-item {
  list-style: none;
}

.footer-nav__list a:hover,
.footer-nav__list a:focus-visible,
.entry-taxonomy a:hover,
.entry-taxonomy a:focus-visible,
.mobile-nav-contact:hover,
.mobile-nav-contact:focus-visible,
.text-link:hover,
.text-link:focus-visible {
  opacity: 0.85;
}

@media (max-width: 1080px) {
  .posts-grid--journal,
  .posts-grid--preview,
  .footer-inner {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .footer-branding {
    grid-column: 1 / -1;
  }
}

@media (max-width: 960px) {
  .header-nav-wrap {
    display: none;
  }

  .journal-intro__inner,
  .posts-grid--journal,
  .posts-grid--preview,
  .post-navigation .nav-links,
  .footer-inner {
    grid-template-columns: 1fr;
  }

  .journal-preview-header__row {
    align-items: flex-start;
    flex-direction: column;
  }
}

@media (max-width: 640px) {
  .journal-intro__copy,
  .journal-intro__aside,
  .entry-cta,
  .post-navigation a {
    border-radius: 24px;
  }

  .journal-intro__actions,
  .entry-cta__actions,
  .not-found-card__actions {
    flex-direction: column;
  }

  .entry-content {
    font-size: 1rem;
  }

  .entry-content blockquote {
    padding: 1.25rem;
    font-size: 1.3rem;
  }
}

```

