<?php

use App\Core\Config\DotEnv;

/**
 * Composer Autoload
 */
require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

/**
 * Initialize environment variable
 */
(new DotEnv(__DIR__ . DIRECTORY_SEPARATOR . '.env'))->load();

/**
 * Start Session
 */
if (!session_id()) session_start();

/**
 * Load the helper file
 */
require 'core/Helpers/helpers.php';

/**
 * Error reporting
 */
switch ($_ENV['APP_ENVIRONMENT']) {
    case 'production':
        error_reporting(0);
        break;

    default:
        error_reporting(E_ALL);
        break;
}
