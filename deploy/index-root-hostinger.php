<?php

/**
 * Place as: public_html/backend/index.php
 * Laravel project root contains vendor/, bootstrap/, … (same folder as app/, public/).
 * Do NOT use ../ paths — public/index.php uses ../vendor; at project root use ./vendor.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
