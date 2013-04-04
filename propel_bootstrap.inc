<?php 
    // Include the main Propel script
    require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';

    // Initialize Propel with the runtime configuration
    Propel::init("/var/www/build/conf/aptostat-conf.php");

    // Add the generated 'classes' directory to the include path
    set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());
