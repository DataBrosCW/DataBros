<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->render('home');
    }

    public function authorize()
    {
        $this->render('authorize');
    }

    public function authorizeReceive()
    {
        // Search api
        if(isset($_GET['code']) ){
            $_SESSION['user_code'] = $_GET['code'];
            return $this->redirect();
        } else {
            return $this->redirect();
        }
    }


}