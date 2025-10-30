<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Heart Detection Routes
$routes->get('heartdetection', 'HeartDetection::index');
$routes->post('heartdetection/detect', 'HeartDetection::detect');
$routes->get('heartdetection/dataset', 'HeartDetection::dataset');
$routes->get('heartdetection/about', 'HeartDetection::about');
$routes->get('heartdetection/riwayat', 'HeartDetection::riwayat');
$routes->get('heartdetection/detail/(:num)', 'HeartDetection::detail/$1');


// Auth Routes
$routes->get('/login', 'Auth::login');
$routes->post('/auth/attemptLogin', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/attemptRegister', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');

// Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // Tambahkan route admin lainnya di sini
});

// Dokter Routes
$routes->group('dokter', ['filter' => 'auth:dokter'], function($routes) {
    $routes->get('dashboard', 'Dokter\Dashboard::index');
    // Tambahkan route dokter lainnya di sini
});

// Pasien Routes
$routes->group('pasien', ['filter' => 'auth:pasien'], function($routes) {
    $routes->get('dashboard', 'Pasien\Dashboard::index');
    // Tambahkan route pasien lainnya di sini
});