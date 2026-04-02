<?php
namespace App\Models;
use CodeIgniter\Model;

class DepotModel extends Model {
    protected $table = 'depot_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['points', 'date_depot', 'dispo', 'id_utilisateur', 'id_borne'];

    public function getTotalPoints($id_utilisateur) {
    
    return $this->where('id_utilisateur', $id_utilisateur)
                ->selectSum('points')
                ->first()['points'] ?? 0; // Retourne 0 si l'utilisateur n'a pas encore de dépôts
}

}

