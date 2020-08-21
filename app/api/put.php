<?php
require_once('../modal/_init.php');
require_once('api.php');

class ApiPut extends API {

    private $data;

    public function __construct(){
        parent::__construct();
        $this->_init();
    }

    protected function _init(){
        parent::deliver_response(array('status'=>501));
        
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