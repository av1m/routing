<?php 

require_once('../modal/_init.php');
require_once('api.php');

class ApiDelete extends API {

    public function __construct(){
        parent::__construct();        
        self::_init();
    }
    
    protected function _init(){
        // We check if we have a shortCode in $_GET['request']
        if (_get('request')){
            $query = $this->shortener->delete(_get('request'));
            if ($query >= 1){
                parent::deliver_response(
                    array('status' => '200')
                );   
            } else {
                parent::deliver_response(array('status' => 404));
            }
        } else {
            parent::deliver_response(array('status' => 404));
        }
    }
}

?>