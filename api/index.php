<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set storage path to /tmp for serverless environment
$app->useStoragePath($_ENV['APP_STORAGE'] ?? '/tmp/storage');

// Run the application
$request = Illuminate\Http\Request::capture();
$app->handleRequest($request);
