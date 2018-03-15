<?php

class HomeController extends Controller
{
    public function index()
    {
        dd(auth_user()->mostVisitedProduct());
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
            $tempCode = urldecode($_GET['code']);

            // We need to retrieve one
            $client = new \GuzzleHttp\Client([
                'base_uri' => config('ebay.base_url', true),
            ]);
            $response = $client->post(config('ebay.endpoints.token_auth',true),[
                'headers' => config('ebay.headers.token_auth',true),
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => config('ebay.redirect_uri'),
                    'code' => $tempCode
                ]
            ]);

            $token = json_decode( $response->getBody() )->access_token;

            $_SESSION['user_code'] = $token;
            return $this->redirect();
        } else {
            return $this->redirect();
        }
    }


}