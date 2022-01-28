<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->post('register', 'Register::index');
$routes->post('login', 'Login::index');

$routes->get('feed', 'Feed::index', ['filter' => 'auth']);
$routes->get('feed/(:num)/(:num)', 'Feed::index/$1/$2', ['filter' => 'auth']);

$routes->get('page', 'Page::index', ['filter' => 'auth']);
$routes->get('page/(:num)', 'Page::show/$1', ['filter' => 'auth']);
$routes->post('page', 'Page::create', ['filter' => 'auth']);

$routes->get('post', 'Post::index', ['filter' => 'auth']);
$routes->get('post/(:num)', 'Post::show/$1', ['filter' => 'auth']);
$routes->post('post', 'Post::create', ['filter' => 'auth']);
$routes->post('post/(:num)', 'Post::create/$1', ['filter' => 'auth']);

$routes->put('follow_page/(:num)', 'Follow::page/$1', ['filter' => 'auth']);
$routes->put('follow_person/(:num)', 'Follow::person/$1', ['filter' => 'auth']);
$routes->post('follow_page/(:num)', 'Follow::page/$1', ['filter' => 'auth']);
$routes->post('follow_person/(:num)', 'Follow::person/$1', ['filter' => 'auth']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
