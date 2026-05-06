<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'apiAuth' => \App\Filters\ApiAuth::class,
        //  On a supprimé l'alias 'session' ici pour stopper les crashs
    ];

    public array $required = [
    'before' => [
        'forcehttps',
        'pagecache',
    ],
    'after' => [
        'pagecache',
        'performance',
        // 'toolbar', 
    ],
];

    public array $globals = [
        'before' => [
            // On laisse ce tableau vide pour éviter que Shield ne se lance tout seul
        ],
        'after' => [
            //'toolbar',
        ],
    ];

    public array $methods = [];
    public array $filters = [
        'apiAuth' => ['before' => ['api/*']],
    ];


    
}
