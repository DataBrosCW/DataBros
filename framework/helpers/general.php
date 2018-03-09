<?php

/**
 * Return a variable from the configuration
 */
function config($name, $noReccursion=false) {
    $config = $GLOBALS['config'];
    $itemPath = explode(".",$name);

    foreach ($itemPath as $path){
        $config = $config[$path];
    }

    if(strpos($name,'ebay')!==false && !$noReccursion) return configReplace($config);
    return $config;
}

/**
 * Add token to the config field
 */
function configReplace($array){
    if (!is_array($array)) return $array;
    foreach($array as $key => $value){
        if (is_array($value)) {
            $array[ $key ] = configReplace( $value );
        } elseif(is_string($value)) {
            $value = str_replace('__appToken__',appToken(),$value);
            $value = str_replace('__userToken__',userToken(),$value);
            $array[ $key ] = $value ;
        }
    }
    return $array;
}

/**
 * CSRF Protection
 */
function generateToken()
{
    $sessionId = session_id();
    return sha1( $sessionId.config('app_key') );
}

/**
 *  Verify that given token was successfully received
 */
function checkToken($token){
    return $token === generateToken();
}

/**
 * Display the csrf hidden field in a form
 */
function csrf_field()
{
    echo '<input type="hidden" name="csrf_token" value="'.generateToken().'"/>';
}

/**
 * Make sure app token is up to date or updates it
 */
function checkOrUpdateAppToken()
{
    $appToken = ApplicationTokenModel::instantiate()->all()->limit(1)->get();

    if (! ($appToken && $appToken instanceof ApplicationTokenModel && (new Carbon\Carbon($appToken->expires_at))->gt(\Carbon\Carbon::now()) )){

        if ($appToken instanceof ApplicationTokenModel) {
            $appToken->delete();
        }

        // We need to retrieve one
        $client = new \GuzzleHttp\Client([
            'base_uri' => config('ebay.base_url', true),
        ]);
        $response = $client->post(config('ebay.endpoints.token_auth',true),[
            'headers' => config('ebay.headers.token_auth',true)
            ,
            'form_params' => [
                'grant_type' => 'client_credentials',
                'redirect_uri' => 'German_Mikulski-GermanMi-sample-amcujbjxm',
                'scope' => 'https://api.ebay.com/oauth/api_scope'
            ]
        ]);

        $body = json_decode($response->getBody());
        $token = $body->access_token;
        $expires_in = $body->expires_in;
        $expires_at = new \Carbon\Carbon();
        $expires_at->addSeconds($expires_in);

        $appToken = new ApplicationTokenModel([
            'token' => $token,
            'expires_at' => $expires_at->format("Y-m-d H:m:s")
        ]);
        $appToken->save();
    }

    return $appToken;
}

/**
 * Returns the app token string
 */
function appToken(){
    return checkOrUpdateAppToken()->token;
}


/**
 * Make sure app user has a user token or retrieve it
 */
function userTokenRoute()
{
    if (!auth_check()) return;

    return  config('ebay.endpoints.user_token') . '?client_id=' .
         config('ebay.client_id') . '&redirect_uri=' . config('ebay.redirect_uri')
         . '&response_type=' . config('ebay.response_type') . '&scope=' . config('ebay.scope');

}

function userToken()
{
    if (isset($_SESSION['user_code'])){
        return $_SESSION['user_code'];
    }
    return;
}


