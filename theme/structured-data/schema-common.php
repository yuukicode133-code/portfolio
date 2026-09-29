<?php
/**
 * 全ページ共通の構造化データ（Person / WebSite）
 */

function yuuki_portfolio_schema_person_id() {
	return home_url( '/#person' );
}

function yuuki_portfolio_schema_website_id() {
	return home_url( '/#website' );
}
function yuuki_portfolio_schema_breadcrumb_id() {
	return home_url( '/#breadcrumb' );
}


function yuuki_portfolio_schema_breadcrumb() {
	if ( is_front_page() || ! function_exists( 'bcn_breadcrumb_trail' ) ) {
		return array();
	}

	$trail = new bcn_breadcrumb_trail();
	$trail->fill();
	$breadcrumbs = array_reverse( $trail->breadcrumbs );

	$items = array();
	$position = 1;

	foreach ( $breadcrumbs as $crumb ) {
		$item = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $crumb->get_title(),
		);

		$url = $crumb->get_url();
		if ( ! empty( $url ) ) {
			$item['item'] = $url;
		}

		$items[] = $item;
		$position++;
	}

	if ( count( $items ) < 2 ) {
		return array();
	}

	return array(
		array(
			'@type'           => 'BreadcrumbList',
			'@id'             => home_url( '/#breadcrumb' ),
			'itemListElement' => $items,
		),
	);
}

function yuuki_portfolio_schema_common() {
	$person = array(
		'@type'       => 'Person',
		'@id'         => yuuki_portfolio_schema_person_id(),
		'name'        => 'Yuuki',
		'url'         => home_url( '/' ),
		'jobTitle'    => 'Webコーダー',
		'description' => '奈良在住のWebコーダー。HTML/CSS・jQuery・WordPress・GSAPを使ったサイト制作を行っています。',
		'address'     => array(
			'@type'          => 'PostalAddress',
			'addressRegion'  => '奈良県',
			'addressCountry' => 'JP',
		),
		'skills'      => array(
			'HTML', 'CSS', 'SCSS', 'jQuery', 'JavaScript',
			'GSAP', 'ScrollTrigger', 'WordPress', 'PHP',
			'Vite', 'Git', 'GitHub', 'Figma',
		),
		'sameAs'      => array(
			'https://github.com/yuukicode133-code',
			'https://x.com/yuuki__main_ac',
		),
	);

	$website = array(
		'@type'      => 'WebSite',
		'@id'        => yuuki_portfolio_schema_website_id(),
		'url'        => home_url( '/' ),
		'name'       => get_bloginfo( 'name' ),
		'inLanguage' => 'ja',
		'publisher'  => array( '@id' => yuuki_portfolio_schema_person_id() ),
	);

    return array_merge( array( $person, $website ), yuuki_portfolio_schema_breadcrumb() );
}