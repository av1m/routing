<?php

require_once('../modal/_init.php');
require_once('api.php');

class ApiGet extends API
{
    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    protected function _init()
    {
        if (count($this->params) == 0) {
            $data = $this->shortener->list();
        } else if (key_exists('short_code', $this->params)) {
            $data = $this->shortener->getByCode(htmlspecialchars($this->params['short_code']));
        } else if (key_exists('id', $this->params)) {
            $data = $this->shortener->getById(htmlspecialchars($this->params['id']));
        } else parent::deliver_response(array('status' => 400));
        if (!$data) parent::deliver_response(array('status' => 404));
        parent::deliver_response(
            array(
                'status' => '200',
                'data' => array("count" => count($data), "data" => $data)
            )
        );
    }
}
