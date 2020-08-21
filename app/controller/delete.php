<?php

require_once("../modal/_init.php");
$errors = array();
$shorten = null;

// We need a id !
if (_get('id') || _get('short_code')) {
    // In all case we retrieve the the shorten url
    $shortener = new Shortener();
    $shorten = _get('id') ? $shortener->getById(_get('id')) : $shortener->getByCode(_get('short_code'));
    try{
        if (!empty($shorten)) {
            $success = $shortener->deleteByCode($shorten[0]->short_code);
            if ($success >= 1){
                header('Location: ../controller/list.php');
            } else {
                echo "<script>
                    if(confirm('An error has occurred')) document.location = '../controller/list.php';
                </script>";
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

_include('delete', array('titre' => 'Delete a shortened URL', 'errors' => $errors));