<?php
function yuuki_portfolio_schema_contact() {
	$url = yuuki_portfolio_schema_current_url();

	$webpage = array(
		'@type'      => 'ContactPage',
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => single_post_title( '', false ),
		'inLanguage' => 'ja',
		'isPartOf'   => array( '@id' => yuuki_portfolio_schema_website_id() ),
		'breadcrumb' => array( '@id' => yuuki_portfolio_schema_breadcrumb_id() ),
	);

	return array( $webpage );
}