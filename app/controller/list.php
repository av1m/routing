<?php

require_once("../modal/_init.php");
$errors = array();

$shorteners = (new Shortener())->list();

_include('list', array('titre' => 'List all shortened links', 'errors' => $errors, 'shorteners'=>$shorteners));
