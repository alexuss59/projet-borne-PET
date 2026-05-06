<?php

namespace Config;

class Paths
{
    // ARMY : RM rectifie les coordonnées GPS pour trouver le coeur du système
    // Sur une installation standard, le dossier system est souvent à la racine
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    // J-Hope : On confirme que le dossier 'app' est juste au-dessus de 'Config'
    public string $appDirectory = __DIR__ . '/..';

    // Suga : Le dossier writable est à la racine de APPLI_WEB
    public string $writableDirectory = __DIR__ . '/../../writable';

    // Jin : Le dossier tests est à la racine
    public string $testsDirectory = __DIR__ . '/../../tests';

    // V : Les vues sont bien dans app/Views
    public string $viewDirectory = __DIR__ . '/../Views';
}