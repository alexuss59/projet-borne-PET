<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiAuth implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        // [RM] On récupère le jeton dans le header Authorization
        $token = $request->getHeaderLine('Authorization');

        // [JIN] Si le jeton est absent ou ne correspond pas au secret BTS
        if (empty($token) || $token !== 'Bearer MonJetonBorne2026') {
            $response = service('response');
            $response->setStatusCode(401); // Erreur Unauthorized
            return $response->setJSON(['status' => 'Erreur', 'message' => 'Accès BDD refusé : Jeton invalide']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Rien à faire après
    }
}