<?php
function yuuki_portfolio_schema_about() {
	$webpage = array(
		'@type'       => 'AboutPage',
		'@id'         => get_permalink() . '#webpage',
		'url'         => get_permalink(),
		'name'        => get_the_title(),
		'inLanguage'  => 'ja',
		'isPartOf'    => array( '@id' => yuuki_portfolio_schema_website_id() ),
		'about'       => array( '@id' => yuuki_portfolio_schema_person_id() ),
		'breadcrumb'  => array( '@id' => yuuki_portfolio_schema_breadcrumb_id() ),
	);

	return array( $webpage );
}