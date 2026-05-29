<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use App\Models\Mbons;
use App\Models\Msupermarche;

/**
 * @internal
 */
final class BonsAchatTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test de génération du code EAN-13 dans le modèle Mbons.
     * Vérifie que le code généré fait bien 13 caractères, commence par '3'
     * et respecte la clé de contrôle EAN-13 (checksum).
     */
    public function testGenererEAN13RespecteFormat()
    {
        $mBons = new Mbons();

        for ($k = 0; $k < 10; $k++) {
            $code = $mBons->genererEAN13();

            // 1. Vérification de la longueur (13 caractères)
            $this->assertEquals(13, strlen($code), "Le code EAN-13 doit faire exactement 13 caractères.");

            // 2. Vérification du premier chiffre ('3')
            $this->assertEquals('3', $code[0], "Le code EAN-13 généré par Mbons doit commencer par '3'.");

            // 3. Validation de la clé de contrôle EAN-13 (checksum)
            $somme = 0;
            for ($i = 0; $i < 12; $i++) {
                $somme += ($i % 2 === 0) ? (int)$code[$i] : (int)$code[$i] * 3;
            }
            $reste = $somme % 10;
            $expectedChecksum = ($reste === 0) ? 0 : 10 - $reste;
            $actualChecksum = (int)$code[12];

            $this->assertEquals($expectedChecksum, $actualChecksum, "La clé de contrôle EAN-13 générée est incorrecte.");
        }
    }

    /**
     * Test de sécurité : Accès refusé si le Header Authorization est absent
     */
    public function testGenererBonSansTokenRenvoie415Ou401()
    {
        // Envoi d'une requête POST sans header d'autorisation
        $response = $this->post('api/genererBon', [
            'nb_bouteilles' => 10
        ]);

        // Doit renvoyer un statut Unauthorized (401)
        $response->assertStatus(401);
    }

    /**
     * Test de sécurité : Accès refusé si le Token est invalide
     */
    public function testGenererBonAvecTokenInvalideRenvoie401()
    {
        // Envoi d'une requête avec un jeton erroné
        $response = $this->withHeaders([
            'Authorization' => 'Bearer token_invalide_de_test'
        ])->post('api/genererBon', [
            'nb_bouteilles' => 10
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test de validation des données : nb_bouteilles invalide
     */
    public function testGenererBonAvecBouteillesInvalidesRenvoieErreur()
    {
        $mSuper = new Msupermarche();
        $supermarche = $mSuper->first();

        if ($supermarche) {
            $jeton = is_array($supermarche) ? ($supermarche['jeton_api_super'] ?? null) : ($supermarche->jeton_api_super ?? null);

            if ($jeton) {
                // Requête avec nombre de bouteilles négatif ou nul
                $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . $jeton
                ])->post('api/genererBon', [
                    'nb_bouteilles' => 0
                ]);

                // Doit renvoyer une erreur 400 (Bad Request / Validation Error)
                $response->assertStatus(400);
            }
        }
    }
}
