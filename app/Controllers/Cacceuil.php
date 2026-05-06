<?php

namespace App\Controllers;
use App\Models\Msupermarche;
use App\Models\Mborne;

class Cacceuil extends BaseController
{
public function index()
{
    $borneModel = new Mborne();
    $superModel = new Msupermarche();

    // Total supermarchés
    $totalSupermarches = $superModel->countAll();

    // Total bornes
    $totalBornes = $borneModel->countAll();

    $statsBornes = $borneModel->select('niveau, COUNT(*) as count')
        ->groupBy('niveau')
        ->findAll();

    // Calculs à partir des stats
    $bornesDispo = 0;
    $bornesPresquePleines = 0;
    $bornesPleines = 0;

    foreach ($statsBornes as $stat) {
        $niveau = (int)$stat['niveau'];
        if ($niveau !== null) {
            if ($niveau < 95) {
                $bornesDispo += (int)$stat['count'];
            } elseif ($niveau < 100) {
                $bornesPresquePleines += (int)$stat['count'];
            } else {
                $bornesPleines += (int)$stat['count'];
            }
        }
    }

    $data = [
        'totalSupermarches'      => $totalSupermarches,
        'totalBornes'            => $totalBornes,
        'bornesDispo'            => $bornesDispo,
        'bornesPresquePleines'   => $bornesPresquePleines,
        'bornesPleines'          => $bornesPleines,
    ];
    $page['title']   = 'Dashboard';
    $page['contenu'] = view('admin/v_dashbord', $data);
    return view('Commun/v_template', $page);
}


}
