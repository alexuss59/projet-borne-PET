<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('depot', 'Home::depot');
$routes->get('depot_anonyme', 'Home::depot_anonyme');
$routes->post('ajouter_bouteille', 'Home::ajouter_bouteille');
$routes->post('signaler_erreur', 'Home::signaler_erreur');
$routes->get('get_total', 'Home::get_total');
$routes->get('refus', 'Home::refus');
$routes->get('finalisation', 'Home::finalisation');
$routes->get('fin_de_session', 'Home::fin_de_session');
$routes->get('relancer_tapis', 'Home::relancer_tapis');
$routes->get('borne/scan', 'Home::page_scan');
$routes->post('borne/verifier_scan', 'Home::verifier_scan');

// --- LES NOUVELLES ROUTES POUR TES BOUTONS ---
$routes->get('home/cumuler', 'Home::cumuler');
$routes->get('home/imprimer_bon', 'Home::finalisation'); // Redirige vers ta fonction qui marche déjà
$routes->get('deconnexion', 'Home::deconnexion'); // Au cas où tu l'utilises
$routes->get('hs', 'Home::hors_service');
$routes->get('pleine', 'Home::borne_pleine');
$routes->get('check_status', 'Home::check_status');
