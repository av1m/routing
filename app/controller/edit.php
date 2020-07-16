<?php

require_once("../modal/_init.php");
$errors = array();
$shorten = null;
$success = null;

// We need a short code !
if (_get('short_code')) {
    // In all case we retrieve the the shorten url
    $shortener = new Shortener();
    $shorten = $shortener->getByCode(_get('short_code'));
    // We check if we found a data
    try {
        if (!empty($shorten)) {
            $shorten = $shorten[0];
            // We check if the form was validate
            if (_post('url') && _post('submit')) {
                // We check if the alias has been changed
                if ((_post('alias') == $shorten->short_code) && (_post('url') == $shorten->long_url)){
                    array_push($errors, "No information was changed");
                }
                else if (_post('alias') == $shorten->short_code){
                    // We just want to update the url
                    $success = $shortener->editUrlAndShortCode(_post('url'), _post('alias'), true);
                    header("Refresh:0"); // We refresh the page to show the update 
                } else {
                    // We want to update url and alias
                    $success = $shortener->editUrlAndShortCode(_post('url'), _post('alias'), false);
                    header("Refresh:0"); // We refresh the page to show the update
                }
            }
        } else {
            array_push($errors, "Short code does not appear to exist.");
        }
    } catch (\Throwable $th) {
        array_push($errors, $th->getMessage());
    }
    
} else {
    array_push($errors, "No short code was supplied");
}

_include('edit', array('titre' => 'Edit a shortened URL', 'errors' => $errors, 'shorten' => $shorten));
