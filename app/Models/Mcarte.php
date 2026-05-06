<?php

namespace App\Models;
use CodeIgniter\Model;

class Mcarte extends Model
{
    protected $table      = 'supermarche';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nom',
        'adresse',
        'latitude',
        'longitude',
        'jeton_api_super',
    ];
}


