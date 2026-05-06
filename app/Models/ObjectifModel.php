<?php

namespace App\Models; // Suga : Vérifie bien cette ligne

use CodeIgniter\Model;

class ObjectifModel extends Model // Jin : Le nom doit être identique au fichier
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'password', 'objectif'];
    protected $returnType = 'array';
}