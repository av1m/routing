<?php

require_once("../modal/_init.php");
$errors = array();
$shorten = null;

// We need a id !
if (_get('id')) {
    // In all case we retrieve the the shorten url
    $shortener = new Shortener();
    $shorten = $shortener->getById(_get('short_code'));
    try{
        if (!empty($shorten)) {
            $shorten = $shorten[0];
            $success = $shortener->delete(_get('short_code'));
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
