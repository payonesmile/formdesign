<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class IndexController extends HomeController {
    public function index(){
	    
        
        $this->display();
    }
    
    public function preview()
    {
        import('@.Org.Formdesign');
        $formdesign = new \Formdesign;
        
        
        $parse_content = $formdesign->parse_form($_POST['design_content'],$one['fields']);
        
        //print_R($parse_content);exit;
        
        $design_content = $formdesign->unparse_form(array(
            'content_parse'=>$parse_content['parse'],
            'content_data'=>serialize($parse_content['data']),//保存后是 serialize，所以这里也一样
        ),array(),array('action'=>'preview'));
        
        
        $this->assign('design_content',$design_content);
        $this->display();
        
        
    }
    public function parse()
    {
        print_R($_POST);
    }
    
    //测试二维码
    public function qrtest()
    {
        import('@.Org.QRcode');
        //tel:13724026923
        //url:http://www.leipi.org
        //test text
        \QRcode::png('url:http://www.leipi.org', './test.png', 'L',4, 2);
         echo '<img src="/test.png" /><hr/>';  
    }
}