<?php
/**
 * Run the migrations SQL file stored in 'database/'
 *
 * -- DOES NOT WORK --
 */

set_include_path(dirname(__DIR__));

require "framework/core/Framework.php";
//require "framework/database/DB.php";

Framework::run(true);

// Finding migration files
$migrationsPath = dirname(__DIR__).'/database/';
$migrationFiles = array_filter(scandir($migrationsPath),function($fileName) {
    //We only want to consider sql files
    if (substr($fileName,-4)=='.sql') return true;
    return false;
});

// Run each migration
foreach ($migrationFiles as $migration ){
    $sql = file_get_contents($migrationsPath.$migration);
    echo PHP_EOL.'Running migration "'.$migration.'"'.PHP_EOL;
    echo $sql;

}

try {
    $db = new DB();
    echo 'ok';
} finally {
    echo PHP_EOL . 'Finished! '. PHP_EOL;
}

