<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
// Add Credentials to access to development part
function checkCredentials()
{
    $users = array('development' => 'd72749aa617e56fe4dae35f083852653');
    if ((!isset($_SERVER['PHP_AUTH_USER'])) || (!isset($_SERVER['PHP_AUTH_PW']))) {
        return false;
    }
    foreach ($users as $user => $password) {
        if ($user == $_SERVER['PHP_AUTH_USER'] && $password == md5($_SERVER['PHP_AUTH_PW'])) {
            return true;
        }
    }
    return false;
}
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(preg_match ('/^(192\.168\..*|127\.0\.0\.1|fe80::1|::1)/i', @$_SERVER['REMOTE_ADDR']) || php_sapi_name() === 'cli-server')
) {
    if (!checkCredentials()) {
        header('WWW-Authenticate: Basic realm="Secured Area"');
        exit();
    }
}


$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
Debug::enable();

require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
