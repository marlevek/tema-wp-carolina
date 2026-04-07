<?php
/**
 * Rodapé do tema.
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
			<p class="footer-kicker"><?php esc_html_e( 'Blog editorial', 'tema-carolina' ); ?></p>
			<p class="footer-title">Carolina Cunha Levek</p>
			<p class="footer-description">Psicóloga | CRP 08/48278</p>
			<p class="footer-description">Reflexões sobre vínculos, terapia, relações e cuidado emocional com a mesma delicadeza do atendimento clínico.</p>
			<p class="footer-note"><?php esc_html_e( 'Atendimento online e presencial em Curitiba, conectado ao site principal da Carolina.', 'tema-carolina' ); ?></p>
		</div>

		<div class="footer-column">
			<p class="footer-heading"><?php esc_html_e( 'Navegação', 'tema-carolina' ); ?></p>
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Links do rodapé', 'tema-carolina' ); ?>">
				<?php tema_carolina_render_footer_menu(); ?>
			</nav>
		</div>

		<div class="footer-column footer-column--contact">
			<p class="footer-heading"><?php esc_html_e( 'Contato', 'tema-carolina' ); ?></p>
			<p class="footer-contact-line">Curitiba - PR | Atendimento online e presencial</p>
			<p class="footer-contact-line">Rua Emiliano Perneta, 860 - Curitiba, PR</p>
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
				aria-label="<?php esc_attr_e( 'Instagram do perfil Vínculos Sinceros', 'tema-carolina' ); ?>"
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
