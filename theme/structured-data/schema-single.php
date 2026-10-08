<?php
function yuuki_portfolio_schema_single() {
	$url     = yuuki_portfolio_schema_current_url();
	$post_id = get_queried_object_id();
	$title   = single_post_title( '', false );

	$work = array(
		'@type'   => 'WebSite',
		'@id'     => $url . '#work',
		'name'    => $title,
		'creator' => array( '@id' => yuuki_portfolio_schema_person_id() ),
	);

	$site_url = get_field( 'site_url', $post_id );
	if ( $site_url ) {
		$work['url'] = $site_url;
	}

	$webpage = array(
		'@type'      => 'ItemPage',
		'@id'        => $url . '#webpage',
		'url'        => $url,
		'name'       => $title,
		'inLanguage' => 'ja',
		'isPartOf'   => array(
			array( '@id' => yuuki_portfolio_schema_website_id() ),
		),
		'mainEntity' => array( '@id' => $url . '#work' ),
		'breadcrumb' => array( '@id' => yuuki_portfolio_schema_breadcrumb_id() ),
	);

	return array( $webpage, $work );
}