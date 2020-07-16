<?php

require_once("../modal/_init.php");
$errors = array();
$shortCode = null;
$sameShortCode = null;

if (_post('url') && _post('submit')) {
    $shortener = new Shortener();
    // Create the shorten URL
    try {
        $shortCode = $shortener->urlToShortCode(_post('url'), _post('alias'));
    } catch (\Throwable $th) {
        array_push($errors, $th->getMessage());
    }
    // check if the shortCode entered by the user is the same
    if ($shortCode === _post('alias')){
        $sameShortCode = true;
    }
}

_include('create', array('titre' => 'Create a shortened URL', 'errors' => $errors, 'shortCode' => $shortCode, 'sameShortCode'=>$sameShortCode));