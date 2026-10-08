<?php
function yuuki_portfolio_schema_works_archive() {
	$url  = yuuki_portfolio_schema_current_url();
	$name = is_home() ? single_post_title( '', false ) : single_term_title( '', false );

	$webpage = array(
		'@type'      => 'CollectionPage',
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => $name,
		'inLanguage' => 'ja',
		'isPartOf'   => array( '@id' => yuuki_portfolio_schema_website_id() ),
		'breadcrumb' => array( '@id' => yuuki_portfolio_schema_breadcrumb_id() ),
	);

	return array( $webpage );
}