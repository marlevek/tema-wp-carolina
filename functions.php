<?php
/**
 * Funções principais do tema Carolina.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Configuração base do tema.
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
	add_image_size( 'blog-card', 720, 432, array( 'center', 'center' ) );

	register_nav_menus(
		array(
			'primary'      => __( 'Menu institucional', 'tema-carolina' ),
			'blog_primary' => __( 'Menu do blog', 'tema-carolina' ),
			'footer'       => __( 'Menu do rodapé', 'tema-carolina' ),
		)
	);
}
add_action( 'after_setup_theme', 'tema_carolina_setup' );

/**
 * Habilita resumo em páginas para introduções editoriais.
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
	$theme_version     = wp_get_theme()->get( 'Version' );
	$main_css_path     = get_theme_file_path( '/assets/css/main.css' );
	$blog_css_path     = get_theme_file_path( '/assets/css/blog-refinements.css' );
	$main_js_path      = get_theme_file_path( '/assets/js/theme.js' );

	wp_enqueue_style( 'tema-carolina-fonts', tema_carolina_fonts_url(), array(), null );
	wp_enqueue_style( 'tema-carolina-style', get_stylesheet_uri(), array(), $theme_version );
	wp_enqueue_style(
		'tema-carolina-main',
		get_theme_file_uri( '/assets/css/main.css' ),
		array( 'tema-carolina-fonts', 'tema-carolina-style' ),
		file_exists( $main_css_path ) ? (string) filemtime( $main_css_path ) : $theme_version
	);
	wp_enqueue_style(
		'tema-carolina-blog-refinements',
		get_theme_file_uri( '/assets/css/blog-refinements.css' ),
		array( 'tema-carolina-main' ),
		file_exists( $blog_css_path ) ? (string) filemtime( $blog_css_path ) : $theme_version
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
 * Mantém a busca pública do tema focada nos posts do blog.
 *
 * @param WP_Query $query Instância da query principal.
 * @return void
 */
function tema_carolina_filter_search_to_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );

	if ( empty( $post_type ) ) {
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_get_posts', 'tema_carolina_filter_search_to_posts' );

/**
 * Ajusta o comprimento padrão do excerpt.
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
 * Retorna a URL base do site principal em HTML.
 *
 * @return string
 */
function tema_carolina_get_main_site_url() {
	$site_url = (string) apply_filters( 'tema_carolina_main_site_url', 'https://carolinacunhalevek.com.br/' );

	return trailingslashit( $site_url );
}

/**
 * Adiciona uma âncora a uma URL.
 *
 * @param string $url URL base.
 * @param string $fragment Fragmento sem #.
 * @return string
 */
function tema_carolina_add_url_fragment( $url, $fragment ) {
	$fragment = ltrim( (string) $fragment, '#' );

	if ( '' === $fragment ) {
		return $url;
	}

	return strtok( (string) $url, '#' ) . '#' . $fragment;
}

/**
 * Retorna a URL de uma seção do site principal em HTML.
 *
 * @param string $section_id ID da seção.
 * @return string
 */
function tema_carolina_get_main_site_section_url( $section_id ) {
	return tema_carolina_add_url_fragment( tema_carolina_get_main_site_url(), $section_id );
}

/**
 * Retorna a URL de uma seção da home.
 *
 * @param string $section_id ID da seção.
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
 * Retorna a URL da página de blog.
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

	return home_url( '/' );
}

/**
 * Retorna a URL da página editorial "Sobre a Carol" dentro do blog.
 *
 * Se a página ainda não existir, o tema direciona para a seção institucional
 * correspondente no site principal, sem depender do menu do HTML.
 *
 * @return string
 */
function tema_carolina_get_blog_about_url() {
	$page_slugs = array(
		'sobre-a-carol',
		'sobre-carol',
		'sobre-a-carolina',
	);

	foreach ( $page_slugs as $page_slug ) {
		$page = get_page_by_path( $page_slug );

		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			$permalink = get_permalink( $page );

			if ( $permalink ) {
				return $permalink;
			}
		}
	}

	return tema_carolina_get_main_site_section_url( 'sobre-mim' );
}

/**
 * Retorna a URL da seção de temas do blog.
 *
 * @return string
 */
function tema_carolina_get_blog_topics_url() {
	return tema_carolina_add_url_fragment( tema_carolina_get_blog_url(), 'temas' );
}

/**
 * Verifica se uma categoria faz parte da navegação editorial do blog.
 *
 * @param WP_Term|mixed $category Categoria a validar.
 * @return bool
 */
function tema_carolina_is_editorial_category( $category ) {
	$default_category = (int) get_option( 'default_category' );

	if ( ! $category instanceof WP_Term || 'category' !== $category->taxonomy ) {
		return false;
	}

	if ( 'uncategorized' === $category->slug ) {
		return false;
	}

	return $default_category ? (int) $category->term_id !== $default_category : true;
}

/**
 * Retorna as categorias editoriais do blog sem a categoria padrão.
 *
 * @return array<int, WP_Term>
 */
function tema_carolina_get_editorial_categories() {
	$default_category = (int) get_option( 'default_category' );
	$categories       = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'exclude'    => $default_category ? array( $default_category ) : array(),
		)
	);

	return array_values(
		array_filter(
			$categories,
			'tema_carolina_is_editorial_category'
		)
	);
}

/**
 * Retorna as categorias tratadas de um post.
 *
 * @param int $post_id ID do post.
 * @return array<int, WP_Term>
 */
function tema_carolina_get_post_categories( $post_id = 0 ) {
	$categories = get_the_category( $post_id );

	return array_values(
		array_filter(
			(array) $categories,
			'tema_carolina_is_editorial_category'
		)
	);
}

/**
 * Retorna a categoria editorial atual no contexto da página.
 *
 * @param int $post_id ID opcional do post.
 * @return WP_Term|null
 */
function tema_carolina_get_current_editorial_category( $post_id = 0 ) {
	if ( is_category() ) {
		$category = get_queried_object();

		if ( tema_carolina_is_editorial_category( $category ) ) {
			return $category;
		}
	}

	if ( $post_id ) {
		$post_id = (int) $post_id;
	} elseif ( is_singular( 'post' ) ) {
		$post_id = (int) get_queried_object_id();
	} else {
		$post_id = get_the_ID();
	}

	if ( ! $post_id ) {
		return null;
	}

	$categories = tema_carolina_get_post_categories( $post_id );

	return $categories ? $categories[0] : null;
}

/**
 * Retorna os links de categorias de um post com acabamento editorial.
 *
 * @param int $post_id ID do post.
 * @return string
 */
function tema_carolina_get_post_category_links( $post_id = 0 ) {
	$categories = tema_carolina_get_post_categories( $post_id );

	if ( ! $categories ) {
		return '';
	}

	$links = array();

	foreach ( $categories as $category ) {
		$category_link = get_category_link( $category );

		if ( is_wp_error( $category_link ) ) {
			continue;
		}

		$links[] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( $category_link ),
			esc_html( $category->name )
		);
	}

	return implode( '', $links );
}

/**
 * Retorna o tempo estimado de leitura de um post.
 *
 * @param int $post_id ID do post.
 * @return string
 */
function tema_carolina_get_reading_time_label( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$content = get_post_field( 'post_content', $post_id );
	$text    = wp_strip_all_tags( (string) $content );
	$words   = preg_match_all( '/[\p{L}\p{N}\'’-]+/u', $text, $matches );
	$minutes = max( 1, (int) ceil( $words / 180 ) );

	return sprintf(
		/* translators: %s: tempo estimado de leitura em minutos. */
		_n( '%s min de leitura', '%s min de leitura', $minutes, 'tema-carolina' ),
		number_format_i18n( $minutes )
	);
}

/**
 * Retorna um resumo editorial do post.
 *
 * @param int $post_id ID do post.
 * @param int $length Quantidade de palavras.
 * @return string
 */
function tema_carolina_get_post_intro( $post_id = 0, $length = 34 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$excerpt = trim( (string) get_the_excerpt( $post_id ) );

	if ( '' !== $excerpt ) {
		return $excerpt;
	}

	$content = wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) );

	return wp_trim_words( $content, (int) $length );
}

/**
 * Retorna a label de atualização do post quando houver edição posterior.
 *
 * @param int $post_id ID do post.
 * @return string
 */
function tema_carolina_get_post_updated_label( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	if ( get_the_time( 'Ymd', $post_id ) === get_the_modified_time( 'Ymd', $post_id ) ) {
		return '';
	}

	return sprintf(
		/* translators: %s: data da última atualização. */
		__( 'Atualizado em %s', 'tema-carolina' ),
		get_the_modified_date( '', $post_id )
	);
}

/**
 * Dados editoriais da autora do blog.
 *
 * @return array<string, string>
 */
function tema_carolina_get_editorial_signature() {
	return array(
		'name'        => 'Carolina Cunha Levek',
		'role'        => __( 'Psicóloga', 'tema-carolina' ),
		'credential'  => 'CRP 08/48278',
		'description' => __( 'Psicóloga de abordagem relacional sistêmica, escrevendo sobre vínculos, emoções, presença e processo terapêutico com a mesma delicadeza do atendimento clínico.', 'tema-carolina' ),
	);
}

/**
 * Retorna posts relacionados com base nas categorias editoriais.
 *
 * @param int $post_id ID do post atual.
 * @param int $posts_per_page Total de posts.
 * @return WP_Query
 */
function tema_carolina_get_related_posts_query( $post_id = 0, $posts_per_page = 3 ) {
	$post_id    = $post_id ? (int) $post_id : get_the_ID();
	$categories = tema_carolina_get_post_categories( $post_id );
	$term_ids   = wp_list_pluck( $categories, 'term_id' );

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'post__not_in'        => array( $post_id ),
		'posts_per_page'      => max( 1, (int) $posts_per_page ),
		'ignore_sticky_posts' => true,
	);

	if ( $term_ids ) {
		$args['category__in'] = array_map( 'intval', $term_ids );
	}

	return new WP_Query( $args );
}

/**
 * Renderiza a navegação editorial por categorias.
 *
 * @param array<string, mixed> $args Argumentos da navegação.
 * @return void
 */
function tema_carolina_render_editorial_topic_navigation( $args = array() ) {
	$categories = tema_carolina_get_editorial_categories();

	if ( ! $categories ) {
		return;
	}

	$args = wp_parse_args(
		$args,
		array(
			'aria_label'          => __( 'Navegação por temas do blog', 'tema-carolina' ),
			'nav_class'           => 'entry-taxonomy entry-taxonomy--topics',
			'current_category_id' => null,
			'show_all_link'       => true,
			'all_label'           => __( 'Todos os artigos', 'tema-carolina' ),
			'all_url'             => tema_carolina_get_blog_url(),
			'active_all'          => null,
		)
	);

	if ( null === $args['current_category_id'] ) {
		$current_category            = tema_carolina_get_current_editorial_category();
		$args['current_category_id'] = $current_category ? (int) $current_category->term_id : 0;
	}

	if ( null === $args['active_all'] ) {
		$args['active_all'] = empty( $args['current_category_id'] );
	}

	echo '<nav class="' . esc_attr( $args['nav_class'] ) . '" aria-label="' . esc_attr( $args['aria_label'] ) . '">';

	if ( $args['show_all_link'] ) {
		$all_classes = array( 'topic-link' );

		if ( $args['active_all'] ) {
			$all_classes[] = 'is-active';
		}

		echo '<a class="' . esc_attr( implode( ' ', $all_classes ) ) . '" href="' . esc_url( $args['all_url'] ) . '">' . esc_html( $args['all_label'] ) . '</a>';
	}

	foreach ( $categories as $category ) {
		$category_link = get_category_link( $category );

		if ( is_wp_error( $category_link ) ) {
			continue;
		}

		$link_classes = array( 'topic-link' );

		if ( (int) $args['current_category_id'] === (int) $category->term_id ) {
			$link_classes[] = 'is-active';
		}

		echo '<a class="' . esc_attr( implode( ' ', $link_classes ) ) . '" href="' . esc_url( $category_link ) . '">' . esc_html( $category->name ) . '</a>';
	}

	echo '</nav>';
}

/**
 * Renderiza breadcrumbs do contexto editorial.
 *
 * @param array<string, mixed> $args Argumentos opcionais.
 * @return void
 */
function tema_carolina_render_breadcrumbs( $args = array() ) {
	$args  = wp_parse_args(
		$args,
		array(
			'nav_class' => 'journal-breadcrumbs',
		)
	);
	$items = array(
		array(
			'label' => __( 'Blog', 'tema-carolina' ),
			'url'   => tema_carolina_get_blog_url(),
		),
	);

	if ( is_category() ) {
		$current_category = tema_carolina_get_current_editorial_category();

		if ( $current_category ) {
			$items[] = array(
				'label'   => $current_category->name,
				'current' => true,
			);
		}
	} elseif ( is_search() ) {
		$items[] = array(
			'label'   => __( 'Busca', 'tema-carolina' ),
			'current' => true,
		);
	} elseif ( is_singular( 'post' ) ) {
		$post_id          = (int) get_queried_object_id();
		$current_category = tema_carolina_get_current_editorial_category( $post_id );

		if ( $current_category ) {
			$category_link = get_category_link( $current_category );

			if ( ! is_wp_error( $category_link ) ) {
				$items[] = array(
					'label' => $current_category->name,
					'url'   => $category_link,
				);
			}
		}

		$items[] = array(
			'label'   => get_the_title( $post_id ),
			'current' => true,
		);
	} elseif ( is_tag() || is_date() ) {
		$items[] = array(
			'label'   => get_the_archive_title(),
			'current' => true,
		);
	}

	if ( count( $items ) < 2 ) {
		return;
	}

	echo '<nav class="' . esc_attr( $args['nav_class'] ) . '" aria-label="' . esc_attr__( 'Breadcrumbs', 'tema-carolina' ) . '">';
	echo '<ol class="journal-breadcrumbs__list">';

	foreach ( $items as $item ) {
		$is_current = ! empty( $item['current'] );

		echo '<li class="journal-breadcrumbs__item">';

		if ( ! empty( $item['url'] ) && ! $is_current ) {
			echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		} else {
			echo '<span' . ( $is_current ? ' aria-current="page"' : '' ) . '>' . esc_html( $item['label'] ) . '</span>';
		}

		echo '</li>';
	}

	echo '</ol>';
	echo '</nav>';
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
		$message = 'Olá, Carol! Gostaria de agendar minha primeira sessão.';
	}

	return $base_url . '?text=' . rawurlencode( $message );
}

/**
 * Fallback do menu principal do blog.
 *
 * @return array<int, array<string, string>>
 */
function tema_carolina_get_blog_primary_fallback_items() {
	$is_about_page = is_page(
		array(
			'sobre-a-carol',
			'sobre-carol',
			'sobre-a-carolina',
		)
	);
	$is_category_page = is_category();
	$is_blog_home     = is_home();
	$is_blog_context  = $is_blog_home || is_search() || is_tag() || is_date() || $is_category_page;
	$is_blog_single   = is_singular( 'post' );

	return array(
		array(
			'label' => __( 'Início do site', 'tema-carolina' ),
			'url'   => tema_carolina_get_main_site_url(),
		),
		array(
			'label'    => __( 'Blog', 'tema-carolina' ),
			'url'      => tema_carolina_get_blog_url(),
			'current'  => $is_blog_home || ( $is_blog_context && ! $is_category_page ),
			'ancestor' => $is_blog_single || $is_category_page,
		),
		array(
			'label'   => __( 'Sobre a Carol', 'tema-carolina' ),
			'url'     => tema_carolina_get_blog_about_url(),
			'current' => $is_about_page,
		),
		array(
			'label'   => __( 'Temas', 'tema-carolina' ),
			'url'     => tema_carolina_get_blog_topics_url(),
			'current' => $is_category_page,
		),
		array(
			'label' => __( 'Agendar sessão', 'tema-carolina' ),
			'url'   => tema_carolina_get_main_site_section_url( 'agendar' ),
		),
	);
}

/**
 * Fallback do menu de rodapé.
 *
 * @return array<int, array<string, string>>
 */
function tema_carolina_get_footer_fallback_items() {
	return array(
		array(
			'label' => __( 'Home', 'tema-carolina' ),
			'url'   => tema_carolina_get_main_site_url(),
		),
		array(
			'label' => __( 'Sobre a Carol', 'tema-carolina' ),
			'url'   => tema_carolina_get_blog_about_url(),
		),
		array(
			'label' => __( 'Agendar sessão', 'tema-carolina' ),
			'url'   => tema_carolina_get_main_site_section_url( 'agendar' ),
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
		$item_classes = array( 'menu-item' );

		if ( ! empty( $item['current'] ) ) {
			$item_classes[] = 'current-menu-item';
		}

		if ( ! empty( $item['ancestor'] ) ) {
			$item_classes[] = 'current-menu-ancestor';
		}

		echo '<li class="' . esc_attr( implode( ' ', $item_classes ) ) . '">';
		echo '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a>';
		echo '</li>';
	}

	echo '</ul>';
}

/**
 * Renderiza o menu principal do blog.
 *
 * @param string $menu_class Classe da lista.
 */
function tema_carolina_render_blog_primary_menu( $menu_class = 'top-nav__list' ) {
	if ( has_nav_menu( 'blog_primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'blog_primary',
				'container'      => false,
				'menu_class'     => $menu_class,
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);

		return;
	}

	tema_carolina_render_fallback_menu( tema_carolina_get_blog_primary_fallback_items(), $menu_class );
}

/**
 * Renderiza o menu do rodapé.
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
