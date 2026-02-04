<?php

$routes->group('hutangpiutang', ['namespace' => 'App\Modules\Hutangpiutang\Controllers', 'filter' => 'auth'], function ($routes) {
	$routes->get('/', 'HutangPiutangController::index');
	$routes->get('list', 'HutangPiutangController::list');
	$routes->post('create', 'HutangPiutangController::create');
	$routes->post('delete', 'HutangPiutangController::delete');
	$routes->post('pelunasan', 'HutangPiutangController::pelunasan');

	$routes->get('read', 'HutangPiutangController::read');
	$routes->post('update', 'HutangPiutangController::update');
});
