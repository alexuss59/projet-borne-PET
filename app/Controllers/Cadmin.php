<?php

namespace App\Controllers;
use App\Models\Msupermarche;
use App\Models\Mcodesbarres;
use App\Models\Mborne;
use App\Models\Mcarte;

class Cadmin extends BaseController
{
    # Partie Dashboard
    public function dashbord()
    {
        $data['title'] = "Dashboard";
        $page['contenu'] = view('admin/v_dashbord', $data);
        return view('Commun/v_template', $page);
    }


    # Partie Supermarches
    public function supermarches()
    {
        $model  = new Msupermarche();
        $supers = $model->orderBy('nom', 'ASC')->findAll(); 

        $data['supers'] = $model->SupermarchesComptageBornes();
        $page['title']   = 'Supermarchés';
        $page['contenu'] = view('admin/v_supermarches', $data);
        return view('Commun/v_template', $page);
    }

    public function saveSupermarche()
    {
        $model = new Msupermarche();
        $id = $this->request->getPost('id');

        $data = [
            'nom'         => $this->request->getPost('nom'),
            'adresse'     => $this->request->getPost('adresse'),
            'latitude'    => $this->request->getPost('latitude'),
            'longitude'   => $this->request->getPost('longitude'),
        ];
        if ($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }
        return redirect()->to(base_url('Cadmin/supermarches'));
    }

    public function deleteSupermarche($id)
    {
        $model = new Msupermarche();
        $model->delete($id);
        return redirect()->to(base_url('Cadmin/supermarches'));
    }


    # Partie Borne
    public function bornes()
    {
        $borneModel = new Mborne();
        $superModel = new Msupermarche();

        $supermarches = $superModel->SupermarchesComptageBornes();
        
        $bornes = $borneModel->getBornesAvecSupermarches();

        $data = [
            'bornes'       => $bornes,
            'supermarches' => $supermarches,
        ];

        $page['title']   = 'Bornes';
        $page['contenu'] = view('admin/v_bornes', $data);
        return view('Commun/v_template', $page);
    }


    public function saveBorne()
    {
        $borneModel = new Mborne();

        $id = $this->request->getPost('id');

        $data = [
            'niveau'             => $this->request->getPost('niveau') ? $this->request->getPost('niveau') : null,
            'id_supermarche'     => $this->request->getPost('id_supermarche') ?: null,
        ];

        if ($id) {
            $borneModel->update($id, $data);
        } else {
            $borneModel->insert($data);
        }

        return redirect()->to(base_url('Cadmin/bornes'));
    }

    public function deleteBorne($id)
    {
        $borneModel = new Mborne();
        $borneModel->delete($id);
        return redirect()->to(base_url('Cadmin/bornes'));
    }


    #Partie Code Barre
    public function codesBarres()
    {
        $model = new Mcodesbarres();
        $codes = $model->orderBy('id', 'DESC')->findAll();

        $data['codes'] = $codes;
        $page['title']   = 'Codes-barres bouteilles';
        $page['contenu'] = view('admin/v_codesbarres', $data);
        return view('Commun/v_template', $page);
    }

    public function saveCode()
    {
        $model = new Mcodesbarres();

        $id = $this->request->getPost('id');
        $code_barre = trim($this->request->getPost('code_barre'));
        $marque = trim($this->request->getPost('marque'));
        $description = trim($this->request->getPost('description'));

        if (empty($code_barre)) {
            return redirect()->back()->with('error', 'Code-barre obligatoire');
        }

        $data = [
            'code_barre'  => $code_barre,
            'marque'      => $marque ?: null,
            'description' => $description ?: null
        ];

        if ($id) {
            $model->update($id, $data);
        } else {
            if ($model->where('code_barre', $code_barre)->first()) {
                return redirect()->back()->with('error', 'Code-barre existe déjà');
            }
            $model->insert($data);
        }

        return redirect()->to(base_url('Cadmin/codesBarres'))->with('success', 'Bouteille enregistrée');
    }

    public function deleteCode($id)
    {
        $model = new Mcodesbarres();
        $model->delete($id);
        return redirect()->to(base_url('Cadmin/codesBarres'))->with('success', 'Bouteille supprimée');
    }


    # Partie Bons D'achat
    public function bonsAchat()
    {
        $data['title'] = "Bons D'achat";
        $page['contenu'] = view('admin/v_bonsAchat', $data);
        return view('Commun/v_template', $page);
    }


    #Partie Carte
    public function carte()
    {
        $model = new Mcarte();

        //récupère les données de la BDD supermarche + niveau de borne
        $supers = $model
            ->select('supermarche.id, 
                    supermarche.nom, 
                    supermarche.adresse, 
                    supermarche.latitude, 
                    supermarche.longitude, 
                    borne.niveau')
            ->join('borne', 'borne.id_supermarche = supermarche.id', 'left')
            ->where('supermarche.latitude IS NOT NULL', null, false)
            ->where('supermarche.longitude IS NOT NULL', null, false)
            ->findAll();

        $page['title'] = 'Carte des bornes';
        $page['contenu'] = view('admin/v_carte', ['supers' => $supers]);
        return view('Commun/v_template', $page);
    }
}


//bearer token