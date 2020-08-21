<?php
require_once('../modal/_init.php');
require_once('api.php');

/*
    Example
    {
        "long_url": "https://www.google.com/",
        "short_code": "gl"  
    }
    If the short code already exist, we have a HTTP code 206 but we create with a different alias
    Else we have 201
    406 is returned if we have a bad url
*/
class ApiPost extends API
{

    private $data;

    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    protected function _init()
    {
        // Get information
        $this->data = json_decode(file_get_contents('php://input'), true);
        // Verifiy information
        if (isset($this->data) && isset($this->data['long_url']) && isset($this->data['short_code'])) {
            // Create the shorten URL
            try {
                $shortCode = $this->shortener->urlToShortCode(
                    $this->data['long_url'],
                    $this->data['short_code']
                );
            } catch (\Throwable $th) {
                parent::deliver_response(array(
                    "status" => 406,
                    "error" => "URL is not good"
                ));
            }
            // check if the shortCode entered by the user is the same
            // we return HTTP CODE 206 if the short_code is different
            parent::deliver_response(
                array(
                    'status' => $shortCode === $this->data['short_code'] ? 201 : 206,
                    'data' => $this->shortener->getByCode($shortCode)[0]
                )
            );
        } else {
            parent::deliver_response(array('status' => 400, 'error' => 'Need JSON data'));
        }
    }
}
