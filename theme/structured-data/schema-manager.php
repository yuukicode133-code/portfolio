<?php
/**
 * 構造化データの出力を振り分ける
 */

require_once __DIR__ . '/schema-common.php';
require_once __DIR__ . '/schema-front.php';
require_once __DIR__ . '/schema-about.php';

function yuuki_portfolio_output_structured_data() {
	$graph = yuuki_portfolio_schema_common();

	if ( is_front_page() ) {
		$graph = array_merge( $graph, yuuki_portfolio_schema_front() );
	} elseif ( is_page( 'about' ) ) {
		$graph = array_merge( $graph, yuuki_portfolio_schema_about() );
	}

	if ( empty( $graph ) ) {
		return;
	}

	$json = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">'
		. wp_json_encode( $json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}
add_action( 'wp_head', 'yuuki_portfolio_output_structured_data' );