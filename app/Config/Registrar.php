<?php

namespace Config;

class Registrar
{
    public static function Registrars(): array
    {
        return [
            \CodeIgniter\Shield\Config\Registrar::class,
        ];
    }
}