<?php
class AnonceController {
    private $anonceModel;

    public function __construct($anonceModel) {
        $this->anonceModel = $anonceModel;
    }

    public function index() {
        $anonces = $this->anonceModel->getAllAnonces();
        include 'Views/Back/dashboard.twig'; 
    }
}