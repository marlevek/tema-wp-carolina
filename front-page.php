<?php
/**
 * Template da página inicial.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'posts' === get_option( 'show_on_front' ) ) {
	require locate_template( 'home.php', false, false );
	return;
}

$theme_uri               = get_template_directory_uri();
$photo_png               = $theme_uri . '/assets/img/foto-carolina-cunha-levek.png';
$photo_webp              = $theme_uri . '/assets/img/foto-carolina-cunha-levek.webp';
$hero_whatsapp_message   = 'Olá, Carol! Gostaria de agendar minha primeira sessão.';
$cta_whatsapp_message    = 'Olá, Carol! Gostaria de agendar minha sessão.';
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
							Você sente que está vivendo os mesmos conflitos nas suas
							<span class="hero-highlight">relações</span>?
						</h1>
						<p class="hero-text">
							A terapia pode te ajudar a compreender esses padrões, lidar com a ansiedade e construir vínculos mais saudáveis, com atendimento psicológico online e presencial em Curitiba.
						</p>
						<div class="hero-actions">
							<a class="btn btn-primary" href="<?php echo esc_url( $agendar_primeira_sessao ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Agendar primeira sessão', 'tema-carolina' ); ?></a>
							<a class="btn btn-secondary" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Ler artigos', 'tema-carolina' ); ?></a>
						</div>
						<div class="hero-pills" aria-label="<?php esc_attr_e( 'Informações principais', 'tema-carolina' ); ?>">
							<span class="hero-pill"><?php esc_html_e( 'Atendimento online e presencial', 'tema-carolina' ); ?></span>
							<span class="hero-pill"><?php esc_html_e( 'Abordagem relacional sistêmica', 'tema-carolina' ); ?></span>
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
										alt="<?php esc_attr_e( 'Retrato da psicóloga Carolina Cunha Levek', 'tema-carolina' ); ?>"
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
				<h2>Se relacionar tem sido difícil <span class="nowrap">para você?</span></h2>
				<p>Talvez você esteja passando por isso:</p>
			</div>

			<div class="identification-cards">
				<div class="list-panel identification-panel" data-reveal>
					<ul class="icon-list warm">
						<li>Se sente sobrecarregado emocionalmente.</li>
						<li>Vive conflitos repetitivos nos relacionamentos.</li>
						<li>Tem dificuldade de se posicionar.</li>
						<li>Sente ansiedade ou insegurança constante.</li>
						<li>Percebe que algo precisa mudar, mas não sabe por onde começar.</li>
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
				<p>A terapia é um espaço para você falar sobre o que está vivendo, no seu tempo e do seu jeito. Ao longo da vida, vamos construindo formas de nos relacionar e, muitas vezes, repetimos algumas situações sem perceber. Na terapia, é possível olhar para isso com mais clareza, compreender melhor suas emoções e encontrar novas formas de lidar com o que sente e com as suas relações.</p>
				<p>É também um espaço de escuta e acolhimento, sem julgamentos, onde você pode se sentir à vontade para ser quem é.</p>
				<p>Não é preciso estar “no limite” para buscar ajuda. Muitas pessoas procuram terapia apenas quando já estão muito sobrecarregadas, mas ela também pode ser um espaço de prevenção, autoconhecimento e desenvolvimento emocional.</p>
				<p>A terapia é um processo construído a dois. Eu estarei aqui para te acolher e te oferecer ferramentas, e a sua participação e disponibilidade para olhar para si também fazem parte desse caminho.</p>
			</div>

			<aside class="list-panel listening-panel therapy-listening-panel" data-reveal aria-label="<?php esc_attr_e( 'Escuta sistêmica', 'tema-carolina' ); ?>">
				<div class="hero-art-copy">
					<span class="art-label"><?php esc_html_e( 'Escuta sistêmica', 'tema-carolina' ); ?></span>
					<p class="hero-quote">
						<span class="quote-inline" aria-hidden="true">"</span>Vínculos sinceros começam quando você se encontra com você mesmo<span class="quote-inline" aria-hidden="true">"</span>
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
				<p>Sou psicóloga e atuo a partir da abordagem relacional sistêmica.</p>
				<p>Acredito que nossas relações são espaços de construção, onde emoções, histórias e formas de se relacionar se encontram.</p>
				<p>Na Sistêmica, olhamos para além do indivíduo, considerando também os vínculos e o contexto em que ele está inserido.</p>
				<p>Isso permite compreender padrões, ressignificar experiências e construir formas mais saudáveis de viver.</p>
				<p>Meu trabalho é te ajudar a desenvolver relações mais conscientes, leves e autênticas.</p>
				<p>Porque ser autêntico não é ser perfeito, é ser inteiro.</p>
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
					<p>Atendimento com a mesma profundidade e acolhimento, onde você estiver.</p>
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
					<p>Um espaço só seu, para ser acolhido, se expressar com liberdade e se aproximar de si, com mais clareza, cuidado e sentido.</p>
				</article>
			</div>

			<div class="benefits-note" data-reveal>
				<strong>Atenção:</strong> A terapia pode ser um espaço de cuidado e autoconhecimento, no seu tempo e da sua forma. Ainda assim, não posso te garantir resultados, mas certamente alguma transformação acontecerá, pois cada pessoa vive esse processo de um jeito único. Mas você não está sozinho, estou aqui, com disponibilidade para te acolher e te acompanhar ao longo desse processo.
			</div>

			<p class="session-info" data-reveal>Cada processo é único e respeita o seu tempo.</p>
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
						<h2>Reflexões para te acompanhar também fora da sessão</h2>
						<p><?php esc_html_e( 'Uma ponte entre o cuidado clínico e a rotina, com textos sobre vínculos, emoções e relações mais conscientes.', 'tema-carolina' ); ?></p>
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
					<h2 class="entry-title"><?php esc_html_e( 'O blog está pronto para receber os próximos artigos.', 'tema-carolina' ); ?></h2>
					<p><?php esc_html_e( 'Assim que os primeiros textos forem publicados, eles aparecerão aqui na página inicial com a mesma identidade visual do restante do site.', 'tema-carolina' ); ?></p>
					<p>
						<a class="btn btn-secondary" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Acessar página do blog', 'tema-carolina' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="cta-section" id="agendar">
		<div class="container narrow">
			<div class="cta-card" data-reveal>
				<span class="eyebrow light">Primeiro passo</span>
				<h2>Vamos começar?</h2>
				<p class="cta-message">Se você sente que é o momento de olhar com mais cuidado para si e para suas relações, você pode começar agora.</p>
				<a class="btn btn-light" href="<?php echo esc_url( $agendar_sessao_direta ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Agendar minha sessão', 'tema-carolina' ); ?></a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
