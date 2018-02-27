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

    public function test()
    {
        // Search api

//        TODO: replace __appToken__ in each config value and replace headers by a config
//        $client = new \GuzzleHttp\Client([
//            'base_uri' => config('ebay.base_url'),
//        ]);
//        $response = $client->get(config('ebay.endpoints.search'),[
//            'headers' => ['Authorization'=> 'Bearer ' . appToken()]
//        ]);
//
//        $body = json_decode($response->getBody());
//        dd($body);

    }

}