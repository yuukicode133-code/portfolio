<?php
/**
 * トップページ固有の構造化データ（WebPage）
 */

function yuuki_portfolio_schema_front() {
	$webpage = array(
		'@type'       => 'WebPage',
		'@id'         => home_url( '/#webpage' ),
		'url'         => home_url( '/' ),
		'inLanguage'  => 'ja',
		'isPartOf'    => array( '@id' => yuuki_portfolio_schema_website_id() ),
		'about'       => array( '@id' => yuuki_portfolio_schema_person_id() ),
	);

	return array( $webpage );
}