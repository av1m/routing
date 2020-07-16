<?php
require_once('../modal/_init.php');
require_once('api.php');

/*
    Example
    In request we include the shortCode
    {
        "long_url": "https://www.google.com/",
        "short_code": "gl"  
    }
    If the short code already exist, we have a HTTP code 206 but we create with a different alias
    Else we have 201
*/
class ApiPut extends API {

    private $data;

    public function __construct(){
        parent::__construct();
        self::_init();
    }

    protected function _init(){
        // Recuperation des informations à mettre à jour
        $this->data = json_decode(file_get_contents('php://input'), true);
        // Recuperation du short code à mettre à jour
        
        // Verifiy information
        if (isset($this->data) && isset($this->data['long_url']) && isset($this->data['short_code'])){
            // Create the shorten URL
            $shortCode = $this->shortener->urlToShortCode(
                $this->data['long_url'], $this->data['short_code']
            );
            // check if the shortCode entered by the user is the same
            if ($shortCode === $this->data['short_code']){
                parent::deliver_response(
                    array(
                        'status' => 201, 
                        'data' => $this->shortener->get($shortCode)[0]
                    )
                );    
            } else {
                // we return HTTP CODE 206 because the shortCode is different
                parent::deliver_response(
                    array(
                        'status' => 206, 
                        'data' => $this->shortener->get($shortCode)[0]
                    )
                );
            }
        } else {
            parent::deliver_response(array('status' => 400, 'error' => 'Need JSON data'));
        }
    }
}

?>