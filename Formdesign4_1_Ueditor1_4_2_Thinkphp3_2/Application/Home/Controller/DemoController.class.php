<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class DemoController extends HomeController {
    
    protected function model()
    {
        if($this->_obj_model)
            return $this->_obj_model;
        return $this->_obj_model = D('form');
    }
    
   
    //后置操作方法    
    public function _after_add(){   
        if(IS_POST)
            $this->upcache(); 
    }
    //后置操作方法    
    public function _after_edit(){  
        if(IS_POST)
            $this->upcache(); 
    } 
    
    
    //更新缓存
    public function upcache()
    {
        S($this->_controller.'_pageone',null);
        return true;
    }
    
    public function index(){
	    
        $map = array(
            'is_del'=>0,
        );
        $page='';
        $list = array();
        
        $cache = array();
        if(empty($_GET) or $_GET['p']==1)//仅缓存第一页就好了
        {
            $cache = S($this->_controller.'_pageone');
        }
        if($cache)
        {
            $count = $cache['count'];
            $page = $cache['page'];
            $list = $cache['list'];
        }else
        {
            $count = $this->model()->where($map)->count('id');
            if ($count > 0)
            {
                import("@.Org.Util.Page");
                $p = new \Page($count, 5);
                //分页跳转的时候保证查询条件
                foreach ($_GET as $key => $val) {
                    if (!is_array($val)) {
                        $p->parameter .= $key.'=' . urlencode($val) . '&';
                    }
                }
                 //分页显示
                $page = $p->show();
                
                $list = $this->model()->field('id,form_name,form_desc,fields,updatetime,dateline')->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select();
                if(empty($_GET))
                {
                    S($this->_controller.'_pageone',array(
                        'count'=>$count,
                        'page'=>$page,
                        'list'=>$list,
                    ));
                }
            }
        }
        $this->assign('page', $page);
        $this->assign('list', $list);

        
        $this->display();
    }
    
    public function add()
    {
        self::edit();
    }
    public function edit()
    {
        $form_id = intval(I('get.form_id'));
        
        $one = array();
        if($form_id<=0)
        {
            $form_id = intval(I('post.form_id'));
        }
        if($form_id>0)
        {
            $map = array(
                'id'=>$form_id,
                'is_del'=>0,
            );
            $one = $this->model()->where($map)->find();
            if(!$one)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        if(IS_GET)
        {
            $this->assign('one',$one);
            $this->display('edit');
        }
         else
        {
            $form_name = trim(I('post.form_name',''));
            if(empty($form_name))
            {
                $this->error('请填写表单名称!',U('/'.$this->_controller.'/add'));
            }
            $data = array(
                'form_name'=>$form_name,
                'form_desc'=>trim(I('post.form_desc','')),
                'updatetime'=>time(),
            );
            if($form_id>0)
            {
                if($this->model()->where(array('id'=>$form_id))->save($data))
                {
                    
                    $this->success('编辑成功，现在去设计表单。',U('/'.$this->_controller.'/formdesign/form_id/'.$form_id));
                }else
                {
                    $this->error('编辑失败，请重试!');
                }
            }else
            {
                $data['dateline'] = time();
                $form_id = $this->model()->add($data);
                if($form_id<=0)
                {
                    $this->error('添加失败，请重试!');
                }
                $this->success('添加成功，现在去设计表单。',U('/'.$this->_controller.'/formdesign/form_id/'.$form_id));
            }
            
            
           
        }
        
        
        
    }
    
    public function formdesign()
    {
        $form_id = intval(I('get.form_id'));
        if($form_id<=0)
        {
            $form_id = intval(I('post.form_id'));
        }
        if($form_id<=0)
        {
            $this->error('参数有误，请返回重试!');
        }
        $map = array(
            'id'=>$form_id,
            'is_del'=>0,
        );
        $one = $this->model()->where($map)->find();
        if(!$one)
        {
            $this->error('未找到表单数据，请返回重试!');
        }
        
        
        
        if(IS_GET)
        {
            $this->assign('one', $one);
            $this->display();
        }else//post
        {
            
            $design_content = trim($_POST['design_content']);
            
            import('@.Org.Formdesign');
            $formdesign = new \Formdesign;
            $parse_content = $formdesign->parse_form($design_content,$one['fields']);
            $design_content=$parse_content['template'];
            
            $formdesign->parse_table($form_id,$parse_content['add_fields']);//创建表或添加字段
            $data = array(
                'fields'=>$parse_content['fields'],
                'content'=>$parse_content['template'],
                'content_parse'=>$parse_content['parse'],
                'content_data'=>serialize($parse_content['data']),
                'updatetime'=>time(),
            );
            
            $map = array(
                'id'=>$form_id,
            );
            
            $trans = $this->model()->where($map)->save($data);
            
            if(!$trans)
            {
                $this->error('保存失败，请重试！');
            }

			$this->upcache(); 


            $this->success('保存成功！',U('/demo/formdesign/form_id/'.$form_id));
       
            
        }
    }
    //临时预览
    public function temp_preview()
    {
        import('@.Org.Formdesign');
        $formdesign = new \Formdesign;
        

        $parse_content = $formdesign->parse_form($_POST['design_content'],$one['fields']);
        $design_content = $formdesign->unparse_form(array(
            'content_parse'=>$parse_content['parse'],
            'content_data'=>serialize($parse_content['data']),//保存后是 serialize，所以这里也一样
        ),array(),array('action'=>'preview'));
        
        
        $this->assign('design_content',$design_content);
        $this->display();
        
        
    }

    
    //预览记录中的数据
    public function preview()
    {
         $form_id = intval(I('get.form_id'));
        if($form_id<=0)
        {
            $form_id = intval(I('post.form_id'));
        }
        if($form_id<=0)
        {
            $this->error('参数有误，请返回重试!');
        }
        $map = array(
            'id'=>$form_id,
            'is_del'=>0,
        );
        $one = $this->model()->where($map)->find();
        if(!$one)
        {
            $this->error('未找到表单数据，请返回重试!');
        }
        
        
        
        import('@.Org.Formdesign');
        $formdesign = new \Formdesign;
        $design_content = $formdesign->unparse_form($one,array(),array('action'=>'preview'));
        
        $this->assign('one',$one);
        $this->assign('design_content',$design_content);
        $this->display('preview');
        
        
    }
}