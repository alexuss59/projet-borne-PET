<?php
namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model {
    protected $table = 'utilisateur';
    protected $primaryKey = 'id'; // Corrigé : c'est 'id' sur ta photo
    protected $allowedFields = ['login', 'nom', 'prenom', 'qr_code']; 
}