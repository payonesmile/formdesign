<?php
namespace Home\Controller;
use Common\Controller\CommonController;

class HomeController extends CommonController {
    public $_obj_model='';
    
    protected function _initialize(){
        //准备数据
         parent::_initialize();
    }
    
    public function test()
    {
        echo '<h1>HomeController.class.php</h1>';
        phpinfo();
    }

	

}
