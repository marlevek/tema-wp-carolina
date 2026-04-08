<?php
/**
 * Formulário de busca editorial do blog.
 *
 * @package Tema_Carolina
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$search_field_id = wp_unique_id( 'blog-search-field-' );
?>
<form role="search" method="get" class="journal-search-form search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $search_field_id ); ?>">
		<?php esc_html_e( 'Buscar no blog', 'tema-carolina' ); ?>
	</label>
	<div class="journal-search-form__inner">
		<input
			type="search"
			id="<?php echo esc_attr( $search_field_id ); ?>"
			class="journal-search-form__field search-field"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Buscar por ansiedade, vínculos, terapia...', 'tema-carolina' ); ?>"
			autocomplete="off"
		/>
		<input type="hidden" name="post_type" value="post" />
		<button class="btn btn-primary journal-search-form__submit search-submit" type="submit">
			<?php esc_html_e( 'Buscar', 'tema-carolina' ); ?>
		</button>
	</div>
</form>
