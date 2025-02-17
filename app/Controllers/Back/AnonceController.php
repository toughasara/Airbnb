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
    public function validat($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            if ($this->anonceModel->validateAnonce($id)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            exit;
        }
    }


}
