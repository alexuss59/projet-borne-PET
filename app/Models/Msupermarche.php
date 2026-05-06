<?php

namespace App\Models;

use CodeIgniter\Model;

class Msupermarche extends Model
{
    protected $table      = 'supermarche';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'adresse', 'latitude', 'longitude'];

    public function SupermarchesComptageBornes()
    {
        //compte le nb de borne
        return $this->select('supermarche.*, COUNT(borne.id) as nb_bornes')
                    ->join('borne', 'borne.id_supermarche = supermarche.id', 'left')
                    ->groupBy('supermarche.id')
                    ->orderBy('supermarche.nom', 'ASC')
                    ->findAll();
    }
}