<?php
require_once("admin-dashboard/Register.php");
require_once("admin-dashboard/Search.php");

define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/');
define('DISPLAY_ERROR', true);

if (DISPLAY_ERROR) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// helpers
function asset($src)
{
    $domain = trim(CURRENT_DOMAIN, '/ ');
    $src = $domain . '/' . trim($src, '/ ');
    return $src;
}

function setResponse(array $message){
    $message = json_encode($message);
    header('Content-type: application/json');
    echo $message;
    exit();
}

function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
}

function currentDomain()
{
    return protocol() . $_SERVER['HTTP_HOST'];
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function methodField()
{
    return $_SERVER['REQUEST_METHOD'];
}


function uri($reservedUrl,$class,$method,$requestMethod='GET'){

    //current url array

    $currentUrl = explode('?',currentUrl())[0];

    $currentUrl = str_replace(CURRENT_DOMAIN,'', $currentUrl);

    $currentUrl = trim($currentUrl,'/');

    $currentUrlArray = explode('/',$currentUrl);

    $currentUrlArray = array_filter($currentUrlArray);

    //reserved Url Array

    $reservedUrl = trim($reservedUrl,'/');

    $reservedUrlArray = explode('/',$reservedUrl);

    $reservedUrlArray = array_filter($reservedUrlArray);


    if (sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requestMethod){
        return false;
    }

    //match

    $parameters = [];

    for ($key= 0;$key < sizeof($currentUrlArray);$key++){
        if ($reservedUrlArray[$key][0] === "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) -1]  == "}"){
            array_push($parameters,$currentUrlArray[$key]);
        }
        elseif ($currentUrlArray[$key] !== $reservedUrlArray[$key]){
            return false;
        }
    }

    //request parameters

    if (methodField() == 'POST'){
        $request = isset($_FILES) ? array_merge($_POST,$_FILES) : $_POST;

        $parameters = array_merge([$request],$parameters);
    }

    //exec method

    $class = "AdminDashboard\\".$class;
    $object = new $class();
    call_user_func_array(array($object,$method),$parameters);



}

uri('register','Register','index');
uri('register/store','Register','store','POST');

uri('search','Search','index');
uri('search/student','Search','search','POST');











