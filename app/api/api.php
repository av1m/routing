<?php

require_once('../modal/_init.php');
require_once('get.php');
require_once('post.php');
require_once('put.php');
require_once('delete.php');

class API {
    protected $params;
    protected $request;
    protected $shortener;

    public function __construct()
    {
        $this->request = $this->getRequest();
        $this->params = $this->getParams();
        $this->shortener = new Shortener();
    }

    protected function _init(){}

    private function getEndpoint(){
        return explode("/", _get('request'))[0];
    }

    private function getRequest(){
        $request = explode("/", _get('request'));
        // We remove the endpoint (`getEndpoint()`)
        array_shift($request);
        // We are looking for if the string ends with '/'
        if (isset($request[0]) && $request[0] === ''){
            array_shift($request);
        }
        return $request;
    }

    private function getParams(){
        $params = $_GET; 
        unset($params["request"]);
        return $params;
    }

    protected function deliver_response($response){
        // Define HTTP responses
        $http_response_code = array(
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported'
        );
        // Set HTTP Response
        header("Access-Control-Allow-Origin: *");
        header('HTTP/1.1 '.$response['status'].' '.$http_response_code[ $response['status'] ]);
        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');
        // Format data into a JSON response
        if (isset($response['data'])){
            $json_response = json_encode($response['data']);
            // Deliver formatted data
            echo $json_response;
        }
        exit;
    }
}

try {
    
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        new ApiGet();
        break;
    
    case 'POST':
        new ApiPost();
        break;
    
    case 'PUT':
        new ApiPut();
        break;

    case 'DELETE':
        new ApiDelete();
        break;

    default:
        http_response_code(405);
        break;
}

} catch (\Throwable $th) {
    http_response_code(400);
}