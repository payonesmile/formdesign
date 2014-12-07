<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Controller;
use Think\Controller;
import("@.ORG.Util.Input");//用于安全过滤

class CommonController extends Controller {

	
    public $_cjv = 0;//config 中的 CSS_JS_VS 控制 js css 的版本号
    public $_site_url = '';//网站域名 http://wxxx.xxx.com 
    public $_module='';
    public $_controller = '';//当前控制器
    public $_action = '';//当前操作
    public $_timestamp = '';
   
    protected function _initialize(){
		#>>360安全过滤
		self::safe_gpc();
        
        #>>基础准备
        $this->_cjv = C('CSS_JS_VS');
        $this->_site_url =  SITE_URL;
        $this->_module = strtolower(MODULE_NAME);
        $this->_controller = strtolower(CONTROLLER_NAME);
        $this->_action = strtolower(ACTION_NAME);
        $this->_timestamp = TIMESTAMP;
        #>>预处理数据
        $this->assign('_cjv',$this->_cjv);
        $this->assign('_site_url',$this->_site_url);
        $this->assign('_controller',$this->_controller);
        $this->assign('_action',$this->_action);
        
       
        #>>剩下的回到各自 module 中处理
        
        
    }
   

	protected function safe_gpc()
	{
		 //$getfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
         $getfilter="\\b(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
		 $postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
		 $cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
		
		//安全检测 start
		if(!empty($_GET))
		{
			foreach($_GET as $key=>$value)
			{
				self::StopAttack($key,$value,$getfilter);
			}
		}
		/* post 提交，有很多检测过度，暂停止 post*/
		if(!empty($_POST))
		{
			foreach($_POST as $key=>$value){
				self::StopAttack($key,$value,$postfilter);
			}
		}
		
		if(!empty($_COOKIE))
		{
			foreach($_COOKIE as $key=>$value){
				self::StopAttack($key,$value,$cookiefilter);
			}
		}
		//安全检测 end		
	}

	/*安全过滤*/
	public function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq)
	{

		if(is_array($StrFiltValue))
		{
			$StrFiltValue=implode($StrFiltValue);
		}
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1)
		{
				//slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
				//$this->error('操作被拦截，已记录，如有问题请联系管理员');
                
                if(IS_AJAX)//获取
                {
                    $data = array(
                        'error'=>'特殊字条被拦截',
                        'hasError'=>1,
                    );
                    $this->ajaxReturn($data);
                }else
                {
                    $this->error('操作被拦截，已记录，如有问题请联系管理员');
                }
				exit();
		}
	}
    
    /* 空操作，用于输出404页面 */
    public function _empty(){
        //echo '空操作';exit;
        //$this->redirect('Index/index');
    }
    
    public function test()
    {
        //phpinfo();
    }


}?>