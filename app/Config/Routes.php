<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- POINTS D'ENTRÉE PRINCIPAUX ---

// : La page de démarrage (point d'entrée unique)
$routes->get('/', 'Login::index'); 

// : Les formulaires de connexion (bleu) et création (vert)
$routes->get('/login', 'Login::loginForm');
$routes->get('/creation_compte', 'Login::connexion');

// --- NAVIGATION TEMPLATE (Tes Autoroutes) ---

//
$routes->get('/voir-acceuil', 'Login::acceuil');
$routes->get('/voir-bon', 'Login::bon');
$routes->get('/voir-plan', 'Login::plan');
$routes->get('/voir-qr', 'Login::qr');
$routes->get('/voir-objectif', 'Login::objectif');
$routes->get('/voir-explications', 'Login::explications');
$routes->get('/voir-parametres', 'Login::parametres');
$routes->get('/voir-utilisateur', 'Login::utilisateur');


// --- TRAITEMENTS ET ACTIONS ---

//  Envoi des formulaires
$routes->post('/login/verifier', 'Login::verifier');
$routes->post('/connexion/enregistrer', 'Login::enregistrer');
$routes->post('/sauvegarder-profil', 'Login::sauvegarderProfil');
$routes->get('login/fixerObjectif/(:num)', 'Login::fixerObjectif/$1');
$routes->get('login/bon', 'Login::bon'); 
$routes->get('login/creerBon/(:any)/(:num)', 'Login::creerBon/$1/$2');
$routes->post('login/enregistrer', 'Login::enregistrer');

// Déconnexion
$routes->get('/logout', 'Login::logout');

// --- SECTION API (Borne + Admin + Interface) ---

$routes->group('api', function($routes) {
    // Collecte de bouteilles (Borne)
    $routes->post('collecte/depot', 'Api::enregistrerDepot');

    // Bons d'achat (Passerelle Supermarché)
    $routes->post('bons/demander', 'Api::demanderBon');
    $routes->get('bons/verifier/(:any)', 'Api::verifierBon/$1');
});
$routes->get('api', 'Api::index');