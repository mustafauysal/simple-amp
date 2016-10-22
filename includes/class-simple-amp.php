<?php
/**
 * Created by PhpStorm.
 * User: mustafauysal
 * Date: 21/10/2016
 * Time: 18:41
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Simple_AMP {

	public function __construct() {
		add_action( 'init', array( $this, 'setup' ) );
	}

	public function setup() {

		if ( false === apply_filters( 'simple_amp_is_enabled', true ) ) {
			return;
		}

		do_action( 'simple_amp_init' );

		load_plugin_textdomain( 'simple-amp', false, plugin_basename( SIMPLE_AMP_PLUGIN_FILE ) . '/languages' );

		add_rewrite_endpoint( SIMPLE_AMP_QUERY_VAR, EP_ALL );

		add_action( 'wp', array( $this, 'prepare_amp' ) );
	}


	public function prepare_amp() {
		if ( $this->is_amp_endpoint() ) {
			$this->render();
		} else {
			$this->head();
		}
	}

	public function render() {
		add_action( 'template_redirect', array( $this, 'amp_render' ) );
	}


	public function amp_render() {

		// template_redirect fires before template_include
		if ( is_embed() && $template = get_embed_template() ) :
		elseif ( is_404() && $template = get_404_template() ) :
		elseif ( is_search() && $template = get_search_template() ) :
		elseif ( is_front_page() && $template = get_front_page_template() ) :
		elseif ( is_home() && $template = get_home_template() ) :
		elseif ( is_post_type_archive() && $template = get_post_type_archive_template() ) :
		elseif ( is_tax() && $template = get_taxonomy_template() ) :
		elseif ( is_attachment() && $template = get_attachment_template() ) :
			remove_filter( 'the_content', 'prepend_attachment' );
		elseif ( is_single() && $template = get_single_template() ) :
		elseif ( is_page() && $template = get_page_template() ) :
		elseif ( is_singular() && $template = get_singular_template() ) :
		elseif ( is_category() && $template = get_category_template() ) :
		elseif ( is_tag() && $template = get_tag_template() ) :
		elseif ( is_author() && $template = get_author_template() ) :
		elseif ( is_date() && $template = get_date_template() ) :
		elseif ( is_archive() && $template = get_archive_template() ) :
		elseif ( is_paged() && $template = get_paged_template() ) :
		else :
			$template = get_index_template();
		endif;

		$template = apply_filters( 'simple_amp_template', $template );

		ob_start();
		include "$template";
		$output = ob_get_clean();

		$output = apply_filters( 'simple_amp_html_output', $output );
		do_action( 'simple_amp_before_render' );

		$amp = new \Lullabot\AMP\AMP();
		$amp->loadHtml( $output, [ 'scope' => \Lullabot\AMP\Validate\Scope::HTML_SCOPE ] );
		$amp_html = $amp->convertToAmpHtml();
		$amp_html = apply_filters( 'simple_amp_output', $amp_html );

		echo $amp_html;

		do_action( 'simple_amp_after_render' );

		if ( false !== apply_filters( 'simple_amp_debug', false ) ) {
			// Print validation issues and fixes made to HTML provided in the $html string
			print( $amp->warningsHumanText() );
		}

		exit;
	}


	public function head() {
		add_action( 'wp_head', array( $this, 'add_canonical' ) );
	}

	public function add_canonical() {
		if ( false === apply_filters( 'simple_amp_show_canonical', true ) ) {
			return;
		}

		$amp_url = $this->get_amp_url();
		printf( '<link rel="amphtml" href="%s" />', esc_url( $amp_url ) );
	}




	/**
	 * Are we currently on an AMP URL?
	 */
	public function is_amp_endpoint() {
		return false !== get_query_var( SIMPLE_AMP_QUERY_VAR, false );
	}


	public function get_amp_url() {
		global $wp;
		$current_url = home_url( $wp->request ) . '/' . SIMPLE_AMP_QUERY_VAR;

		return apply_filters( 'simple_amp_url', $current_url );
	}

}

new Simple_AMP();
