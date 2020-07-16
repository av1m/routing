<?php

require_once("./app/modal/_init.php");

$getShortenCode = explode("/", _get('r'))[0];

try{
    $shortener = new Shortener();
    // Get URL by short code
    $url = $shortener->shortCodeToUrl($getShortenCode);
    
    // Redirect to the original URL
    header("Location: ".$url);
    exit;
}catch(Exception $e){
    // Display error
    $errors = $e->getMessage();
    echo $errors;
}
