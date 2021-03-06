<?php

class Framework
{

    /**
     * Load the app and starts the router.
     * If $cliMode is activated, router and session won't be initiated
     */
    public static function run($cliMode = false)
    {
        self::init($cliMode);

        self::packages();

        self::autoload();

        if(!$cliMode) {
            self::dispatch();
        }
    }

    /**
     * Define app constant, load core classes and packages
     */
    private static function init($cliMode=false)
    {
        // Define path constants
        define( "DS", DIRECTORY_SEPARATOR );
        define( "ROOT", dirname(dirname(__DIR__)) . DS );
        define( "APP_PATH", ROOT . 'application' . DS );
        define( "FRAMEWORK_PATH", ROOT . "framework" . DS );
        define( "PUBLIC_PATH", ROOT . "public" . DS );
        define( "VENDOR_PATH", ROOT . 'vendor' . DS );

        define( "CONFIG_PATH", APP_PATH . "config" . DS );
        define( "CONTROLLER_PATH", APP_PATH . "controllers" . DS );
        define( "MODEL_PATH", APP_PATH . "models" . DS );
        define( "VIEW_PATH", PUBLIC_PATH . "views" . DS );
        define( "CACHE_PATH", PUBLIC_PATH . "cache" . DS );

        define( "CORE_PATH", FRAMEWORK_PATH . "core" . DS );
        define( 'DB_PATH', FRAMEWORK_PATH . "database" . DS );
        define( "LIB_PATH", FRAMEWORK_PATH . "libraries" . DS );
        define( "HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS );

        // Load packages
        require_once VENDOR_PATH . 'autoload.php';

        // Load core classes
        require CORE_PATH . "Controller.php";
        require DB_PATH . "DB.php";
        require CORE_PATH . "Model.php";

        // Load configuration file
        $GLOBALS['config'] = include CONFIG_PATH . "config.php";

        // Load helpers
        require HELPER_PATH . 'general.php';
        require HELPER_PATH . 'auth.php';

        // Load libraries
        foreach (glob(LIB_PATH. "*.php") as $filename)
        {
            require $filename;
        }

        // Start session
        if (!$cliMode){
            session_start();
        }
    }

    /**
     * Configure used packages
     */
    private static function packages()
    {
        // Pretty error pages
        $whoops = new \Whoops\Run;
        $whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler );
        $whoops->register();

        // Blade templating engine
    }

    /**
     * Autoload of databros app
     */
    private static function autoload()
    {
        spl_autoload_register( array( __CLASS__, 'load' ) );
    }

    private static function load( $classname )
    {
        if ( substr( $classname, - 10 ) == "Controller" && $classname!= "Controller" ) {

            // Controller
            require_once CONTROLLER_PATH . "$classname.php";
        } elseif ( substr( $classname, - 5 ) == "Model" && $classname!= "Model") {

            // Model
            require_once MODEL_PATH . "$classname.php";
        }
    }

    /**
     * Routing part of the app
     */
    private static function dispatch()
    {
        require_once CORE_PATH . 'Router.php';
        $routes = include APP_PATH . 'routes.php';

        $router = new Router();
        foreach ( $routes as $route => $action ) {
            $router->add( $route, $action );
        }
        $router->submit();
    }

}