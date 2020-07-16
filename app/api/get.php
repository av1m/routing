<?php 

require_once('../modal/_init.php');
require_once('api.php');

class ApiGet extends API {

    public function __construct(){
        parent::__construct();        
        self::_init();
    }
    
    protected function _init(){
        if (_get('request')){
            // List depends to request (if i want just one)
            $data = $this->shortener->get(_get('request'))[0];
        } else {
            // list all
            $data = $this->shortener->listAll();
            //var_dump($data);
        }
        if ($data){
            parent::deliver_response(
                array(
                    'status' => '200',
                    'data' => $data
                )
            );
        } else {
            parent::deliver_response(array('status' => 404));
        }
    }
}

?>