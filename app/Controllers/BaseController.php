<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController : La classe parente de tous tes contrôleurs.
 */
abstract class BaseController extends Controller
{
    /**
     * RM : C'est ici qu'on déclare les helpers pour tout le projet.
     * BTS : En ajoutant 'auth', la fonction auth() est reconnue par CodeIgniter.
     */
    protected $helpers = ['auth', 'url', 'form', 'setting'];

    /**
     * Suga : Initialisation du contrôleur.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // RM : On charge les helpers ici pour être sûr qu'ils sont dispos
        $this->helpers = array_merge($this->helpers, ['auth', 'setting', 'url', 'form']);

        parent::initController($request, $response, $logger);
    }
}
