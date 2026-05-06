<?php
namespace App\Models;

use CodeIgniter\Model;

class Mcodesbarres extends Model
{
    protected $table      = 'bouteille';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'code_barre',
        'marque', 
        'description'
    ];
}
