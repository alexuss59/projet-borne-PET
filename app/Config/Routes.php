<?php
use CodeIgniter\Router\RouteCollection;
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
