<?php 

require_once('../modal/_init.php');
require_once('api.php');

class ApiDelete extends API {

    public function __construct(){
        parent::__construct();        
        $this->_init();
    }
    
    protected function _init(){
        $query = 0;
        if (key_exists('short_code', $this->params)) {
            $query = $this->shortener->deleteByCode(htmlspecialchars($this->params['short_code']));
        } else if (key_exists('id', $this->params)) {
            $query = $this->shortener->delete(htmlspecialchars($this->params['id']));
        } else parent::deliver_response(array('status' => 400));
        if ($query >= 1){
            parent::deliver_response(array('status' => '204'));   
        } else {
            parent::deliver_response(array('status' => 404));
        }
    }
}

?>