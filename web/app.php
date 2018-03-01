<?php

use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../app/autoload.php';

$kernel = new AppKernel('prod', false);
//$kernel = new AppCache($kernel);
Request::setTrustedProxies([], Request::HEADER_X_FORWARDED_ALL);$response = $kernel->handle($request);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
