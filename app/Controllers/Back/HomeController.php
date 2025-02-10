<?php
class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Welcome to the Home Page',
            'content' => 'This is the content of the home page.'
        ];
        $this->view('front/home/index', $data);
    }
}