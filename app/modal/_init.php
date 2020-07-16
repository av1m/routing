<?php
@ob_start();
session_start();
// Initialize the resources needed to run the application
require_once("shortener.php");
require_once('database.php');
require_once('url.php');

/**
 * Check if the variable $_POST contains the params
 * and return $_POST['x'] to protect against web vulnerabilities
 * thanks to the htmlspecialchars() function
 * 
 * @param string x value of the array that $_POST must contain
 * @return post or FALSE
 */
function _post($x = "")
{
    if (htmlspecialchars(isset($_POST[$x]))) return htmlspecialchars($_POST[$x]);
    else return FALSE;
}

/**
 * Check if the $_GET variable contains the params
 * and returns $_GET['x'] to protect against web vulnerabilities
 * thanks to the htmlspecialchars() function
 *
 * @param string x value of the array that $_GET must contain
 * @return string or FALSE
 */
function _get($x = "")
{
    if (htmlspecialchars(isset($_GET[$x]))) return htmlspecialchars($_GET[$x]);
    else return FALSE;
}

/**
 * Create the MVC view page
 *
 * example :
 * _include("ajouter_visiteur", array('titre'=>"Ajouter un visiteur", 'errors'=>""))
 * 
 * @param string $view corresponds to the view of the MVC model
 * @param array $params variable passed to view, default value for errors = ""
 * @return void
 */
function _include($view, $params = array())
{
    // Check if errors exist
    if (!array_key_exists('errors', $params)) $params['errors'] = array();
    // Check if errors is a string (if yes, we transform it to a table)
    if (is_string($params['errors'])) $params['errors'] = (empty($params['errors'])) ? array() : array($params['errors']);
    ob_start();
    extract($params);
    // Call views
    include("../views/" . $view . ".php");
    $content = ob_get_clean();
    // Call template
    require('../views/template.php');
}

function _websiteUrlWithoutFile()
{
    $beginUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/";
    $requestUri = explode("/", $_SERVER['REQUEST_URI']);
    // $fullPath = substr($beginUrl, 0, -1).$_SERVER['REQUEST_URI'];
    $finalUrl = false;
    foreach ($requestUri as $key => $u) {
        if ($u === 'app'){
            $finalUrl = $beginUrl . implode('/', array_slice($requestUri, 1, $key-1)) . '/';
            break;
        }
    }
    return $finalUrl; 
}
