<?php
namespace App\Models;

use CodeIgniter\Model;

class Mborne extends Model
{
    protected $table      = 'borne';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'niveau',
        'id_supermarche',
    ];

    // Bornes triées par nom de supermarché
    public function getBornesAvecSupermarches()
    {
        return $this->select('borne.*, supermarche.nom AS nom_supermarche')
                    ->join('supermarche', 'supermarche.id = borne.id_supermarche')
                    ->orderBy('supermarche.nom', 'ASC')
                    ->findAll();
    }
}

