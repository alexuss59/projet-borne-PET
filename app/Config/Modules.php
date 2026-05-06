<?php

namespace Config;

use CodeIgniter\Modules\Modules as BaseModules;

class Modules extends BaseModules
{
    public $enabled = true;

    public $discoverInComposer = true;

    // ARMY : Jin bloque Shield pour éviter l'erreur de table 'settings' manquante
    // On demande au framework d'ignorer le package Shield dans l'auto-discovery
    public $composerPackages = [
        'exclude' => [
            'codeigniter4/shield',
            'codeigniter4/settings',
        ],
    ];

    public $aliases = [
        'events',
        'filters',
        'registrars',
        'routes',
        'services',
    ];
}