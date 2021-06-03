<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Home page
$routes->get('/', 'Pages::home');

// Register page
$routes->match(['get', 'post'], 'inregistrare', 'Users::register');

// Login page
$routes->match(['get', 'post'], 'autentificare', 'Users::login');

// Logout page
$routes->get('delogare', 'Users::logout');

// Resources page
$routes->get('resurse', 'Resources::index');

// Create new post page
$routes->match(['get', 'post'], 'post/creare', 'Resources::create');

// View post page
$routes->match(['get', 'post'], 'post/(:num)', 'Resources::view/$1');

// Edit post page
$routes->match(['get', 'post'], 'post/editare/(:num)', 'Resources::edit/$1');

// Delete post page
$routes->get('post/stergere/(:num)', 'Resources::delete/$1');

// Assign students to teacher page
$routes->match(['get', 'post'], 'profesor/editare/(:num)', 'Users::teacher/$1');

// Teacher's students page
$routes->get('studenti', 'Users::students');

// Tests page
$routes->get('evaluare', 'Tests::index');

// Create new test page
$routes->match(['get', 'post'], 'test/creare', 'Tests::create');

// Start test page
$routes->match(['get', 'post'], 'test/creare/inceput', 'Tests::start');

// View test page
$routes->match(['get', 'post'], 'test/(:num)', 'Tests::view/$1');

// Test with single question page
$routes->match(['get', 'post'], 'test/(:num)/intrebare/(:num)', 'Tests::view/$1/$2');

// Finished test by student page
$routes->match(['get', 'post'], 'test/(:num)/student/(:num)', 'Tests::studentTest/$1/$2');

// Finished tests by all students page
$routes->get('test/(:num)/finalizat', 'Tests::finished/$1');

// Delete test page
$routes->match(['get', 'post'], 'test/stergere/(:num)', 'Tests::delete/$1');

// Admin panel page
$routes->get('admin', 'Admin::index');

// All users page
$routes->get('utilizatori', 'Users::all');

// Change user's role page
$routes->get('utilizator/rol/(:num)', 'Users::role/$1');

// Search a post page
$routes->match(['get', 'post'], 'postari/cautare', 'Resources::search');

// Subjects page
$routes->match(['get', 'post'], 'materii', 'Admin::subjects');

// Delete subject page
$routes->get('materie/(:num)/sterge', 'Admin::deleteSubject/$1');

// Posts sent by students page
$routes->get('postari-studenti/(:num)', 'StudentPosts::index/$1');

// Single post sent by student page
$routes->get('postare-student/(:num)', 'StudentPosts::view/$1');

// Messages page
$routes->get('mesaje', 'Messages::index');

// Create new message page
$routes->match(['get', 'post'], 'mesaj/creare', 'Messages::create');

// View message page
$routes->match(['get', 'post'], 'mesaj/(:num)', 'Messages::view/$1');

// Delete message page
$routes->get('mesaj/stergere/(:num)', 'Messages::delete/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
