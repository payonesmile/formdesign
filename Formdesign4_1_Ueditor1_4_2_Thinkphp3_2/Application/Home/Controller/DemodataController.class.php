<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class DemodataController extends HomeController {
    
    protected function model($form_id)
    {
        if($form_id<=0)
            return false;
            
        if($this->_obj_model)
            return $this->_obj_model;
        return $this->_obj_model = D('form_data_'.$form_id);
    }
    
    
    public function index(){
	    
        $form_id = intval(I('get.form_id'));
        $map = array(
            'id'=>$form_id,
            'is_del'=>0,
        );
        $form_one = D('form')->where($map)->find();
        if(!$form_one)
        {
            $this->error('未找到表单，请返回重试!');
        }
        
        
        $list = array();
        $map = array(
            'form_id'=>$form_id,
            'is_del'=>0,
        );
        $count = D('foreign_test')->where($map)->count('id');
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
            
            $list = D('foreign_test')->field('id,name,updatetime,dateline')->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select();
            
        }
        
        
        $this->assign('form_one',$form_one);
        $this->assign('page', $page);
        $this->assign('list', $list);

        
        $this->display();
    }
    public function view()
    {
        $form_id = intval(I('get.form_id'));
        $id = intval(I('get.id'));
        $form_one  = $one = $form_data = array();

        if($form_id>0)
        {
            $map = array(
                'id'=>$form_id,
                'is_del'=>0,
            );
            $form_one = D('form')->where($map)->find();
            if(!$form_one)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        
        if($id>0)
        {
            $map = array(
                'id'=>$id,
                'form_id'=>$form_id,
                'is_del'=>0,
            );
            $one = D('foreign_test')->where($map)->find();
            if(!$one)
            {
                $this->error('未找到数据，请返回重试!');
            }
            
            $map = array(
                'foreign_id'=>$id,
                'is_del'=>0,
            );
            $form_data = $this->model($form_id)->where($map)->find();
            if(!$form_data)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        
        import('@.Org.Formdesign');
        $formdesign = new \Formdesign;
        
        
        $design_content = $formdesign->unparse_form($form_one,$form_data,array('action'=>'view'));
        
        $this->assign('one',$one);
        $this->assign('form_one',$form_one);
        $this->assign('design_content',$design_content);
        
        $this->display();
   
        
    }
    
    public function add()
    {
        self::edit();
    }
    public function edit()
    {
        $form_id = intval(I('get.form_id'));
        $id = intval(I('get.id'));
        
        $form_one  = $one = $form_data = array();
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
            $form_one = D('form')->where($map)->find();
            if(!$form_one)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        
        if($id<=0)
        {
            $id = intval(I('post.id'));
        }
        if($id>0)
        {
            $map = array(
                'id'=>$id,
                'form_id'=>$form_id,
                'is_del'=>0,
            );
            $one = D('foreign_test')->where($map)->find();
            if(!$one)
            {
                $this->error('未找到数据，请返回重试!');
            }
            
            $map = array(
                'foreign_id'=>$id,
                'is_del'=>0,
            );
            $form_data = $this->model($form_id)->where($map)->find();
            if(!$form_data)
            {
                $this->error('未找到表单数据，请返回重试!');
            }
        
        }
        
        import('@.Org.Formdesign');
        $formdesign = new \Formdesign;
        
        
        if(IS_GET)
        {
            
            $design_content = $formdesign->unparse_form($form_one,$form_data,array('action'=>'edit'));
            
            $this->assign('one',$one);
            $this->assign('form_one',$form_one);
            $this->assign('design_content',$design_content);
            
            $this->display('edit');
        }
         else
        {
            
            $name = trim(I('post.name',''));
            if(empty($name))
            {
                $this->error('请填写标识!',U('/'.$this->_controller.'/add/form_id/'.$form_id));
            }
            
            //form data   使用  foreign_id 关联，你也可以在 foreign_test保存form data 的 ID，根据实际情况决定
            //抽出自定义字段
            $unparse_data = $formdesign->unparse_data($form_one,$_POST);

            $data = array(
                'name'=>$name,
                'updatetime'=>time(),
            );
            $form_data = array(
                'uid'=>0,
                'updatetime'=>time(),
            );
            
            $foreign_test_model = D('foreign_test');
            $foreign_test_model->startTrans(); 

            if($id>0)
            {
                $trans = $foreign_test_model->where(array('id'=>$id))->save($data);
                if($trans)
                {
                    $form_data = array_merge($form_data,$unparse_data);
                    $map = array(
                        'foreign_id'=>$id,
                        'is_del'=>0,
                    );
                    
                    $trans = $this->model($form_id)->where($map)->save($form_data);
                }
                if(!$trans)
                {
                    $foreign_test_model->rollback();
                    $this->error('编辑失败，请重试!');
                }else
                {
                    $foreign_test_model->commit();
                    $this->error('编辑成功!');
                }
            }else
            {
                $data['form_id'] = $form_id;
                $data['dateline'] = time();
                $id  = $trans = $foreign_test_model->add($data);
                if($trans)
                {
                    $form_data['foreign_id'] = $id;
                    $form_data['dateline'] = time();
                    $form_data = array_merge($form_data,$unparse_data);
                    $trans = $this->model($form_id)->add($form_data);
                }
                if($id<=0)
                {
                    $foreign_test_model->rollback();
                    $this->error('添加失败，请重试!');
                }else
                {
                    $foreign_test_model->commit();
                    $this->error('添加成功!',U('/demodata/edit/form_id/'.$form_id.'/id/'.$id));
                }
            }
            
           
            
            
            
            
            
            
            
           
        }
        
        
        
    }
    
    
    
}