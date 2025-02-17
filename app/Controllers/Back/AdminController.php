<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Models\Back\AnonceModel;

class AdminController extends Controller
{
    private $anonceModel;

    public function __construct()
    {
        parent::__construct();
        $this->anonceModel = new AnonceModel();
    }
    public function dashboard()
    {
        $anonces = $this->anonceModel->getAllAnnonces();
        $this->render('Back/dashboard.twig', [
            'title' => 'Dashboard',
            'anonces' => $anonces


        ]);
    }
}
