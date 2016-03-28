<?php
error_reporting(E_ALL | E_ALL);

$origin = getOrigin();
$request = $_REQUEST['request'];

$args = explode('/', rtrim($request, '/'));

// retrieve model
$resource = $args[0];

include_once 'classes/' . $resource. '.php';

if (class_exists($resource))
{
    $modelAPI = new $resource($origin, $request);
    $result = $modelAPI->process();

    echo $result;
}
else
{
    die('Resource URI not found');
}

function getOrigin()
{
    if (!array_key_exists('HTTP_ORIGIN', $_SERVER))
    {
        $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
    }

    return $_SERVER['HTTP_ORIGIN'];
}




