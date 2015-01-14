<?php
    
class Formdesign
{
    /*
        PHP 解析表单
        template 表单设计器里的Html内容
        fields 字段总数
    */
    public function  parse_form($template,$fields=0)
    {
        //获取标签
        //$preg =  "/<(img|input|textarea|select).*?(<\/select>|<\/textarea>|\/>)/s";
        /*
            //正则  radios|checkboxs|select 
            js 匹配的边界 |--|  因为当使用 {} 时js报错
            php 要保持一致，也使用 |--| 也可以是直接 {|- -|}
        */
        $preg =  "/(\|-<span(((?!<span).)*leipiplugins=\"(radios|checkboxs|select)\".*?)>(.*?)<\/span>-\||<(img|input|textarea|select).*?(<\/select>|<\/textarea>|\/>))/s";
        //获取属性  修改为可变 的匹配
        $preg_attr ="/(\w+)=\"(.?|.+?)\"/s";
        //获取单选组复选
        $preg_group ="/<input.*?\/>/s";
        $template_parse =$template; 
        preg_match_all($preg,$template,$temparr);

        $template_data = $add_fields = array();
        $checkboxs =0;
        if($temparr)
        {
            foreach($temparr[0] as $pno=>$plugin)
            {
                
                $tag = empty($temparr[6][$pno]) ? $temparr[4][$pno] : $temparr[6][$pno];

                $attr_arr_all = array();
                $name = $leipiplugins = $select_dot = '';
                $is_new=false;


                if(in_array($tag,array('radios','checkboxs')))//这两个在下面也要//清空边界
                {

                    $plugin = $temparr[2][$pno];

                }else if($tag =='select')
                {
                    $plugin = str_replace(array('|-','-|'),'',$plugin);//清空边界
                }
                 

                     
               

                preg_match_all($preg_attr,$plugin,$parse_attr);
                
                foreach($parse_attr[1] as $k=>$attr)
                {
                    $attr = trim($attr);
                    if($attr)
                    {
                        
                        $val = $parse_attr[2][$k];
                        if($attr=='name')
                        {
                           
                            if($val=='leipiNewField')
                            {
                                $is_new=true;
                                $fields++;
                                $val = 'data_'.$fields;
                            }
                            $name = $val;
                        }
                        
                        if($tag=='select' && $attr=='value')
                        {
                            $attr_arr_all[$attr] .= $select_dot . $val;
                            $select_dot = ',';
                        }else
                        {
                            $attr_arr_all[$attr] = $val;
                        }
                    }
                }

                if($tag =='checkboxs') /*复选组  多个字段 */
                {
                    $plugin = $temparr[0][$pno];
                    $plugin = str_replace(array('|-','-|'),'',$plugin);//清空边界

                    $name = 'checkboxs_'.$checkboxs;
                    $attr_arr_all['parse_name'] = $name;
                    $attr_arr_all['name'] = '';
                    $attr_arr_all['value'] = '';
                    $options = $temparr[5][$pno];
                    preg_match_all($preg_group,$options,$parse_group);
                    $dot_name = $dot_value = '';

                    $attr_arr_all['content'] = '<span leipiplugins="checkboxs" title="'.$attr_arr_all['title'].'">';
                    foreach($parse_group[0] as $value)
                    {
                        preg_match_all($preg_attr,$value,$parse_attr);
                        $is_new=false;
                        $option = array();
                        foreach($parse_attr[1] as $k=>$val)
                        {
                            $tmp_val = $parse_attr[2][$k];
                            if($val=='name')
                            {
                               
                                if($tmp_val=='leipiNewField')
                                {
                                    $is_new=true;
                                    $fields++;
                                    $tmp_val = 'data_'.$fields;
                                }
                                $attr_arr_all['name'] .= $dot_name . $tmp_val;
                                $dot_name = ',';
                            }else if($val=='value')
                            {
                                $attr_arr_all['value'] .= $dot_value . $tmp_val;
                                $dot_value = ',';
                            }

                            $option[$val] = $tmp_val;
                                
                        }
                        $attr_arr_all['options'][] = $option;
                        if($is_new)
                        {
                            $add_fields[$option['name']] = array(
                                'name'=>$option['name'],
                                'leipiplugins'=>$attr_arr_all['leipiplugins']
                            );
                        }
                        $checked = isset($option['checked']) ? 'checked="checked"' : '';//判断isset 就可以,在ie中，checked的值是空的
						
                        $attr_arr_all['content'] .= '<input type="checkbox" name="'.$option['name'].'" value="'.$option['value'].'" '.$checked.'/>'.$option['value'].'&nbsp;';
                       
                    }
                    $attr_arr_all['content'] .= '</span>'; //需要content   replace

                    //parse
                    $template = self::str_replace_once($plugin,$attr_arr_all['content'],$template);
                    $template_parse = self::str_replace_once($plugin,'{'.$name.'}',$template_parse);
                    $template_parse = str_replace(array('{|-','-|}'),'',$template_parse);//清空边界
                    $template_data[$pno] = $attr_arr_all;
                    $checkboxs++;


                }
                else if($name) 
                {
                    if($tag =='radios') /*单选组  一个字段*/
                    {
                        $plugin = $temparr[0][$pno];
                        $plugin = str_replace(array('|-','-|'),'',$plugin);//清空边界

                        $attr_arr_all['value'] = '';
                        $options = $temparr[5][$pno];
                        preg_match_all($preg_group,$options,$parse_group);
                        $dot = '';
                        
                        $attr_arr_all['content'] = '<span leipiplugins="radios" name="'.$attr_arr_all['name'].'" title="'.$attr_arr_all['title'].'">';
                        foreach($parse_group[0] as $value)
                        {
                            preg_match_all($preg_attr,$value,$parse_attr);
                            $option = array();
                            foreach($parse_attr[1] as $k=>$val)
                            {
                                if($val=='value')
                                {
                                    $attr_arr_all['value'] .= $dot . $parse_attr[2][$k];
                                    $dot = ',';
                                }
                                $option[$val] = $parse_attr[2][$k];
                                    
                            }
                            $option['name'] = $attr_arr_all['name'];
                            $attr_arr_all['options'][] = $option;
                            $checked = isset($option['checked']) ? 'checked="checked"' : '';//判断isset 就可以,在ie中，checked的值是空的
                            $attr_arr_all['content'] .='<input type="radio" name="'.$attr_arr_all['name'].'" value="'.$option['value'].'"  '.$checked .'/>'.$option['value'].'&nbsp;';

                        }
                        $attr_arr_all['content'] .= '</span>'; //需要content   replace
                        
                    }else
                    {
                        $attr_arr_all['content'] = $is_new ? str_replace('leipiNewField',$name,$plugin) : $plugin;
                    }

                    $template = self::str_replace_once($plugin,$attr_arr_all['content'],$template);
                    $template_parse = self::str_replace_once($plugin,'{'.$name.'}',$template_parse);
                    $template_parse = str_replace(array('{|-','-|}'),'',$template_parse);//清空边界
                    if($is_new)
                    {
                        $add_fields[$name] = array(
                            'name'=>$name,
                            'leipiplugins'=>$attr_arr_all['leipiplugins']
                        );
                    }

                    $template_data[$pno] = $attr_arr_all;

                }

            }
        }
        $parse_form = array(
            'fields'=>$fields,
            'template'=>$template,
            'parse'=>$template_parse,
            'data'=>$template_data,
            'add_fields'=>$add_fields,
        ); 
        //print_r($parse_form);exit;
        return $parse_form;
        
        
    }
    /*只替换一次*/
    public function str_replace_once($needle,$replace,$haystack)
    {
        $pos = strpos($haystack,$needle);
        if($pos === false)
        {
            return $haystack;
        }else
        {
            return substr_replace($haystack,$replace,$pos,strlen($needle));
        }
    }
    //获取控件字段类型 的sql 
    public function field_type_sql($leipiplugins)
    {
        if($leipiplugins=='textarea' or $leipiplugins=='listctrl')
        {
            return 'text NOT NULL';
        }
        else if($leipiplugins=='checkboxs')
        {
            return 'tinyint(1) UNSIGNED NOT NULL DEFAULT 0';
        }
        else
        {
            return 'varchar(255) NOT NULL DEFAULT \'\'';
        }
    }
    //返回表名
    public function tname($tname)
    {
        $tname = strtolower($tname);
        return C('DB_PREFIX').$tname;
    }
    /*
    * 创建数据表， 通过fields自动计算字段增长
    * 表中存取数据利用 foreign_id 进行
    */
    public function parse_table($formid,$add_fields)
    {
        
        $tname = self::tname("form_data_".$formid);
        $sql = "select count(*) from ".$tname." where id = '1'";
        $exist =  M()->execute($sql);
        if($exist ===false)
        {
            $fields = '';
            foreach($add_fields as $value)
            {
                $fields .='`'.$value['name'].'` '.self::field_type_sql($value['leipiplugins']).',';
            }
            
            $sql = "CREATE TABLE `".$tname."` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `uid` int(10) unsigned NOT NULL DEFAULT '0',
              `foreign_id` int(10) unsigned NOT NULL DEFAULT '0',
              ".$fields."
              `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
              `dateline` int(10) unsigned NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`),
              KEY `uid` (`uid`),
              KEY `foreign_id` (`foreign_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            
            $create =  M()->execute($sql);
            if($create !== false)
                $create = true;
            return $create;    
        }else
        {
            $fields = D("form_data_".$formid)->getDbFields();
            $dot = '';
            $sql = "ALTER TABLE `".$tname."` ";
            foreach($add_fields as $value)
            {
                if(!in_array($value['name'],$fields))
                {
                    $sql.= $dot . "ADD COLUMN `".$value['name']."` ".self::field_type_sql($value['leipiplugins']);
                    $dot = ',';
                }
            }
            $sql .=';'; 
            if($dot!='')
            {
                $create =  M()->execute($sql);
                if($create !== false)
                    $create = true;
                return $create;    
            }
        }
        return true;
    }
    
    /*
    * 编译字段
    * $controller = array(
    *   'action'=>'edit,view,preview', //编辑 或 查看  、预览  两种不同情况解析
    *   'user'=>array(
    *           'uid'=>9527,
    *           'real_name'=>'唐伯虎',
    *           'dept'=>'华府',
    *       ),
    *   'else'='其它要传进来的数据',
    * );
    */
    public function unparse_form($form,$form_data=array(),$controller=array())
    {
        $tpl_data = unserialize($form['content_data']);
        $tpl = $form['content_parse'];
        //表格样式
        $tpl = str_replace('<table','<table class="table table-bordered"', $tpl);

        foreach($tpl_data as $key=>$value)
        {
            $temp_html = '';
            
            $value['value'] = isset($form_data[$value['name']]) ? $form_data[$value['name']] : $value['value'];//通用
            
            switch($value['leipiplugins'])
            {
                case 'text':
                    $temp_html = '<input type="text" value="'.$value['value'].'"  name="'.$value['name'].'"  style="'.$value['style'].'"/>';
                    break;
                case 'textarea':
                        $temp_html = '<textarea  name="'.$value['name'].'" id="'.$value['name'].'" value="'.$value['value'].'" style="'.$value['style'].'">';
                        $temp_html.=$value['value'];
                        $temp_html .= '</textarea>';
                        if($value['orgrich'])
                        {
                            $temp_html .= '<script>
                                UE.getEditor("'.$value['name'].'",{
                                    toolbars:[[
                                    "fullscreen", "source", "|","bold", "italic", "underline","|", "justifyleft", "justifycenter", "justifyright", "justifyjustify"]],wordCount:false,elementPathEnabled:false
                                 });</script>';
                        }
                    break;
                case 'radios':
                    $temp_html =  '';
                    foreach($value['options'] as $item)
                    {
                        $checked = '';
                        if(isset($form_data[$value['name']]))//原 默认值
                        {
                           $checked =  $form_data[$value['name']] == $item['value'] ? 'checked="checked"' : '';
                        }else if(isset($item['checked']))//判断isset 就可以,在ie中，checked的值是空的
                        {
                            $checked = 'checked="checked"';
                        }
                        $temp_html .='<input type="radio" name="'.$value['name'].'" value="'.$item['value'].'" '.$checked.'>'.$item['value'].'&nbsp;';
                    }
                    break;
                case 'checkboxs':
                    $temp_html = '';

                    foreach($value['options'] as $item)
                    {
                        $checked = '';
                        if(isset($form_data[$item['name']]))//原 默认值
                        {
                           $checked =  $form_data[$item['name']] >0 ? 'checked="checked"' : '';
                        }else if(isset($item['checked']))//判断isset 就可以,在ie中，checked的值是空的
                        {
                            $checked = 'checked="checked"';
                        }
                        $temp_html .='<input type="checkbox" name="'.$item['name'].'" value="'.$item['value'].'" '.$checked.'>'.$item['value'].'&nbsp;';
                       
                    }
                    $value['name'] = $value['parse_name'];
                    break;
               case 'select':
                    //设置过默认值  清空它  
                    if(isset($form_data[$value['name']]))
                    {
                        if(isset($value['selected']))
                        {
                            $value['content'] = str_replace('selected="selected"','',$value['content']);
                        }
                        $selected = '';
                        if($form_data[$value['name']]==$value['value'])
                            $selected = 'selected="selected"';
                        //重新定义默认值 
                        $value['content'] = str_replace('value="'.$value['value'].'"','value="'.$value['value'].'" '.$selected,$value['content']);
                    }
                    $temp_html = $value['content']; 
                    break;
               case 'macros':
                    $temp_html = self::macros_parse($value,$form_data[$value['name']],$controller);
                    break;
               case 'progressbar':
                    if($controller['action']=='edit')
                    {
                        $value['value'] = floatval($value['value']);
                        $value['value'] = $value['value']>0 ? $value['value'] : floatval($value['orgvalue']);
                        $temp_html ='进度 <input type="text" style="width:40px" name="'.$value['name'].'" value="'.$value['value'].'"/> %'; 
                    }else if($controller['action']=='view')
                    {
                        $temp_html = '<div class="progress progress-striped"><div class="bar '.$value['orgsigntype'].'" style="width: '.$value['value'].'%;"></div></div>';
                    }else if($controller['action']=='preview')
                    {
                        $temp_html = '<div class="progress progress-striped"><div class="bar '.$value['orgsigntype'].'" style="width: '.$value['orgvalue'].'%;"></div></div>';
                    }
                   
                    break;
               case 'qrcode'://未处理生成二维码
               
                    $orgtype = '';
                    if($value['orgtype']=='text')
                    {
                        $orgtype = '文本';
                    }else if($value['orgtype']=='url')
                    {
                        $orgtype = '超链接';
                    }else if($value['orgtype']=='tel')
                    {
                        $orgtype = '电话';
                    }
                    if($value['value'])
                        $qrcode_value = unserialize($value['value']);
                        //print_R($qrcode_value);exit;  //array(value,qrcode_url)
                    if($controller['action']=='edit')
                    {
                        $temp_html = $orgtype.'二维码 <input type="text" name="'.$value['name'].'" value="'.$qrcode_value['value'].'"/>'; 
                    }else if($controller['action']=='view')
                    {
                        //可以采用  http://qrcode.leipi.org/ 

                        $style = '';
                        if($value['orgwidth']>0)
                        {
                            $style .= 'width:'.$value['orgwidth'].'px;';
                        }
                        if($value['orgheight']>0)
                        {
                            $style .= 'height:'.$value['orgheight'].'px;';
                        }
                        $temp_html = '<img src="'.$qrcode_value['qrcode_url'].'" title="'.$qrcode_value['value'].'" style="'.$style.'"/>'; 


                    }else if($controller['action']=='preview')
                    {
                        $style = '';
                        if($value['orgwidth']>0)
                        {
                            $style .= 'width:'.$value['orgwidth'].'px;';
                        }
                        if($value['orgheight']>0)
                        {
                            $style .= 'height:'.$value['orgheight'].'px;';
                        }
                        $temp_html = '<img src="'.$value['src'].'" title="'.$value['orgtype'].'" style="'.$style.'"/>'; 
                    }
                    
                    break;

                case 'listctrl':
                        
                        //编辑数据
                        $def_value[$key] = !empty($value['value']) ? unserialize($value['value']) : '';

                        $orgtitle = rtrim($value['orgtitle'],'`');
                        $orgcoltype = rtrim($value['orgcoltype'],'`');
                        $orgunit = rtrim($value['orgunit'],'`');
                        $orgsum = rtrim($value['orgsum'],'`');
                        $orgcolvalue = rtrim($value['orgcolvalue'],'`');

                        $orgtitle_arr = explode('`', $orgtitle);
                        $orgcoltype_arr = explode('`', $orgcoltype);
                        $orgunit_arr = explode('`', $orgunit);
                        $orgsum_arr = explode('`', $orgsum);
                        $orgcolvalue_arr = explode('`', $orgcolvalue);


//查看
if($controller['action'] =='view')
{
    
                        $th_th = $tb_td = $tf_td = '';
                       $is_sum = 0;
                       $td_sum = 0;
                       foreach ($orgtitle_arr as $k => $val) {
                            $td_sum++;

                            // thead
                           $th_th .= '<th>'.$val.'</th>';
                           //tbody
                           $tb_td.='<td></td>';

                           //tfooter
                           if($orgsum_arr[$k]>0)//需要合计
                           {
                                $tf_td .='<td>合计：0 '.$orgunit_arr[$k].'</td>';
                           }else
                           {
                                $tf_td .='<td></td>';
                           }
                           
                       }


                       //有编辑值时，还原table
                       $tb_tf_tr = '';//tbody  tfooter
                       if($def_value[$key])
                       {
                            foreach($def_value[$key]['list'] as $dk=>$dval)
                            {
                                $tb_td = $tf_td = '';
                                $is_sum = 0;
                                foreach ($orgtitle_arr as $k => $val) {
                                    $is_sum++;
                                    //tbody
                                       $tb_td.='<td>'.$dval[$k].' '.$orgunit_arr[$k].'</td>';

                                       //tfooter
                                       if($orgsum_arr[$k]>0)//需要合计
                                       {
                                            $tf_td .='<td>合计：'.(int)$def_value[$key]['sum'][$k].' '.$orgunit_arr[$k].'</td>';
                                       }else
                                       {
                                            $tf_td .='<td></td>';
                                       }
                                }
                                $tb_tf_tr .='<tr>'.$tb_td.'</tr>';
                            }
                       }

                        $temp_html .='<table id="'.$value['name'].'_table" cellspacing="0" class="table table-bordered table-condensed" style="'.$value['style'].'">';
                        $temp_html .='<thead>
                                        <tr><th colspan="'.($td_sum).'">'.$value['title'].'</th></tr>
										<tr>'.$th_th.'</tr>
                                        <tr>
                                        </thead>';

                            if($def_value[$key])//有编辑值时，还原table
                            {
                                $temp_html .= '<tbody>'.$tb_tf_tr.'</tbody>';

                            }else//刚发起的公文，没编辑值时，默认一行
                            {
                                    $temp_html .='<tbody>
                                          <tr class="template">'.$tb_td.'
                                          </tr>
                                        </tbody>';
                                    
                            }
                            if($is_sum>0)
                            {
                                $temp_html .='<tfooter>
                                  <tr>'.$tf_td.'
                                  </tr>
                                </tfooter>';
                            }

                        $temp_html .='</table>';

    
}else//可写
{



                        $temp_html ='<script>
                            function tbAddRow(dname)
                            {
                                var sTbid = dname+"_table";
                                $("#"+sTbid+" .template")  
                                    //连同事件一起复制    
                                    .clone(true)    
                                    //去除模板标记    
                                    .removeClass("template")  
                                    //修改内部元素 
                                    .find(".delrow").show().end()
                                    .find("input").val("").end()
                                    .find("textarea").val("").end()
                                    //插入表格    
                                   .appendTo($("#"+sTbid));
                            }
                            //统计
                            function sum_total(dname,e){
                                
                                var tsum = 0;
                                $(\'input[name="\'+dname+\'[]"]\').each(function(){
                                    var t = parseFloat($(this).val());
                                    if(!t) t=0;
                                    if(t) tsum +=t;
                                    $(this).val(t);
                                }); 
                                $(\'input[name="\'+dname+\'[total]"]\').val(tsum);

                            }

                            /*删除tr*/
                            function fnDeleteRow(obj)
                            {
                                var sTbid = "'.$value['name'].'_table";
                                var oTable = document.getElementById(sTbid);
                                while(obj.tagName !="TR")
                                {
                                    obj = obj.parentNode;
                                }
                                oTable.deleteRow(obj.rowIndex);
                            }
                        </script>';
                        //print_R($value);exit;

                        

                        

                       $th_th = $tb_td = $tf_td = '';
                       $is_sum = 0;
                       $td_sum = 0;
                       foreach ($orgtitle_arr as $k => $val) {
                            $td_sum++;

                            //前期
                            $sum_total_html = '';
                            if($orgsum_arr[$k]>0)//需要合计
                            {
                                $is_sum ++;
                                $orgcoltype_arr[$k]=='int';//必须数值
                                $sum_total_html = 'onblur="sum_total(\''.$value['name'].'['.$k.']\')"';
                            }

                            // thead
                           $th_th .= '<th>'.$val.'</th>';
                           //tbody
                           if($orgcoltype_arr[$k]=='text')
                           {
                                $tb_td.='<td><input class="input-medium" type="text" name="'.$value['name'].'['.$k.'][]" value="'.$orgcolvalue_arr[$k].'"> '.$orgunit_arr[$k].'</td>';
                           }else if($orgcoltype_arr[$k]=='textarea')
                           {
                                $tb_td.='<td><textarea class="input-medium" name="'.$value['name'].'['.$k.'][]" >'.$orgcolvalue_arr[$k].'</textarea> '.$orgunit_arr[$k].'</td>';
                           }else if($orgcoltype_arr[$k]=='int')
                           {
                                $tb_td.='<td><input class="input-medium" '.$sum_total_html.' type="text" name="'.$value['name'].'['.$k.'][]" value="'.$orgcolvalue_arr[$k].'"> '.$orgunit_arr[$k].'</td>';
                           }else if($orgcoltype_arr[$k]=='calc')//公式，暂未处理
                           {
                                $tb_td.='<td><input class="input-medium" type="text" name="'.$value['name'].'['.$k.'][]" value="'.$orgcolvalue_arr[$k].'"> '.$orgunit_arr[$k].'</td>';
                           }
                           //tfooter
                           if($orgsum_arr[$k]>0)//需要合计
                           {
                                $tf_td .='<td>合计：<input type="text" class="input-small" name="'.$value['name'].'['.$k.'][total]" onblur="sum_total(\''.$value['name'].'['.$k.'][]\')" value="'.$orgcolvalue_arr[$k].'"> '.$orgunit_arr[$k].'</td>';
                           }else
                           {
                                $tf_td .='<td></td>';
                           }
                           
                       }


                       //有编辑值时，还原table
                       $tb_tf_tr = '';//tbody  tfooter
                       if(!empty($def_value[$key]['list']))
                       {
                            foreach($def_value[$key]['list'] as $dk=>$dval)
                            {
                                $tb_td = $tf_td = '';
                                $is_sum = 0;
                                foreach ($orgtitle_arr as $k => $val) {
                                    $is_sum++;

                                    //前期
                                    $sum_total_html = '';
                                    if($orgsum_arr[$k]>0)//需要合计
                                    {
                                        $is_sum ++;
                                        $orgcoltype_arr[$k]=='int';//必须数值
                                        $sum_total_html = 'onblur="sum_total(\''.$value['name'].'['.$k.']\')"';
                                    }

                                    //tbody
                                       if($orgcoltype_arr[$k]=='text')
                                       {
                                            $tb_td.='<td><input class="input-medium" type="text" name="'.$value['name'].'['.$k.'][]" value="'.$dval[$k].'"> '.$orgunit_arr[$k].'</td>';
                                       }else if($orgcoltype_arr[$k]=='textarea')
                                       {
                                            $tb_td.='<td><textarea class="input-medium" name="'.$value['name'].'['.$k.'][]" >'.$dval[$k].'</textarea> '.$orgunit_arr[$k].'</td>';
                                       }else if($orgcoltype_arr[$k]=='int')
                                       {
                                            $tb_td.='<td><input class="input-medium" '.$sum_total_html.' type="text" name="'.$value['name'].'['.$k.'][]" value="'.$dval[$k].'"> '.$orgunit_arr[$k].'</td>';
                                       }else if($orgcoltype_arr[$k]=='calc')//公式，暂未处理
                                       {
                                            $tb_td.='<td><input class="input-medium" type="text" name="'.$value['name'].'['.$k.'][]" value="'.$dval[$k].'"> '.$orgunit_arr[$k].'</td>';
                                       }
                                       //tfooter
                                       if($orgsum_arr[$k]>0)//需要合计
                                       {
                                            $tf_td .='<td>合计：<input type="text" class="input-small" name="'.$value['name'].'['.$k.'][total]" onblur="sum_total(\''.$value['name'].'['.$k.'][]\')" value="'.(int)$def_value[$key]['sum'][$k].'"> '.$orgunit_arr[$k].'</td>';
                                       }else
                                       {
                                            $tf_td .='<td></td>';
                                       }
                                }
                                $delrow_hide = '';
                                $one_tr = '';//作为模板
                                if($dk==0)
                                {
                                    $delrow_hide = 'hide';
                                    $one_tr = 'class="template"';
                                }
                                $tb_tf_tr .='<tr '.$one_tr .'>'.$tb_td.'<td><a href="javascript:void(0);" onclick="fnDeleteRow(this)" class="delrow '.$delrow_hide.'">删除</a></td></tr>';
                            }
                       }

                        $temp_html .='<table id="'.$value['name'].'_table" cellspacing="0" class="table table-bordered table-condensed" style="'.$value['style'].'">';
                        $temp_html .='<thead>
                                        <tr><th colspan="'.($td_sum+1).'">
                                        '.$value['title'].'
                                            <span class="pull-right">
                                                <button class="btn btn-small btn-success" type="button" onclick="tbAddRow(\''.$value['name'].'\')">添加一行</button>
                                            </span>
                                        </th></tr>
                                        <tr>
                                          <tr>'.$th_th.'<th>操作</th></tr>
                                        </thead>';

                            if(!empty($def_value[$key]['list']))//有编辑值时，还原table
                            {
                                $temp_html .= '<tbody><tr></tr>'.$tb_tf_tr.'</tbody>';

                            }else//刚发起的公文，没编辑值时，默认一行
                            {
                                    $temp_html .='
                                          <tr class="template">'.$tb_td.'
                                            <td><a href="javascript:void(0);" onclick="fnDeleteRow(this)" class="delrow hide">删除</a></td>
                                          </tr>
                                        </tbody>';
                                    
                            }
                            if($is_sum>0)
                            {
                                $temp_html .='<tfooter>
                                  <tr>'.$tf_td.'
                                    <td></td>
                                  </tr>
                                </tfooter>';
                            }

                        $temp_html .='</table>';
                       
     
}//可写










                    break;
                default:
                    $temp_html = $value['content']; 
            }
            if($value['name'])
                $tpl = str_replace('{'.$value['name'].'}',$temp_html,$tpl);
        }
       
       return $tpl;
       
    }
    
    public function macros_parse($data,$def_value='',$controller=array())
    {
        
        $tpl = $data['content'];
        $date_format = '';
        switch($data['orgtype'])
        {
            case 'sys_date':
                $date_format = 'Y-m-d';break;
            case 'sys_date_cn':
                $date_format = 'Y年n月j日';break;
            case 'sys_date_cn_short3':
                $date_format = 'Y年';break;
            case 'sys_date_cn_short4':
                $date_format = 'Y';break;
            case 'sys_date_cn_short1':
                $date_format = 'Y年m月';break;
            case 'sys_date_cn_short2':
                $date_format = 'm月d日';break;
            case 'sys_time':
                $date_format = 'H:i:s';break;
            case 'sys_datetime':
                $date_format = 'Y-m-d H:i:s';break;
            case 'sys_week'://周
                if(!$def_value)
                {
                    $dateArray  =   getdate($date);
                    $wday = $dateArray["wday"];
                    $week = array("日","一","二","三","四","五","六");
                    $def_value = '星期'.$week[$wday];
                }
                $tpl = str_replace('{macros}',$def_value,$tpl);
                break;
            case 'sys_userid':
                if(!$def_value)
                    $def_value = $controller['user']['uid'];
                $tpl = str_replace('{macros}',$def_value,$tpl);
                break;
            case 'sys_realname':
                if(!$def_value)
                    $def_value = $controller['user']['real_name'];
                $tpl = str_replace('{macros}',$def_value,$tpl);
                break;
            default:
                $tpl = str_replace('{macros}','未完善的宏控件',$tpl);
                break;
        }
        //时间
        if($date_format)
        {
            $def_value = str_replace('年','-',$def_value);
            $def_value = str_replace('月','-',$def_value);
            $def_value = str_replace('日','',$def_value);
            $def_value = trim($def_value,'-');

            $timestamp = 0;
            if($def_value)
            {
                if(strlen($def_value)==4)
                {
                    $def_value .='-01';
                }
                $timestamp = strtotime($def_value);
               
            }
            else
            {
                $timestamp = time();
            }
            
            if(!$timestamp)
            {
                $tpl = str_replace('{macros}',$def_value,$tpl);//时间转换失败时
            }else
            {
                $tpl = str_replace('{macros}',date($date_format,$timestamp),$tpl);
            }
        }

        return $tpl;
        
    }
    
    
    
    
    //抽出表单提交后 控件的值

    public function unparse_data($form,$post_data,$controller=array())
    {
        $tpl_data = unserialize($form['content_data']);

        $return_data = array();
        foreach($tpl_data as $key=>$value)
        {
            switch($value['leipiplugins'])
            {
                //不同的类型，可以加入不同的处理方式

                case 'checkboxs'://包含多个 name
                    foreach($value['options'] as $val)
                    {
                        $return_data[$val['name']] = isset($post_data[$val['name']]) ? 1 : 0;
                        //$return_data[$val['name']]= $post_data[$val['name']] ? trim($post_data[$val['name']]) : '';
                    }
                    break;
                case 'qrcode'://生成二维码
                    //可以采用  http://qrcode.leipi.org/ 
                    $qrcode_url = '';
                    
                    $qrcode = $post_data[$value['name']] ? trim($post_data[$value['name']]) : '';
                    if($qrcode)
                    {
                        import('@.Org.QRcode');//import 为Thinkphp内置，使用其它框架请换成： include_once     
                        $qrcode_file = 'Uploads/'.md5($qrcode).'.png';
                        $qrcode_url = '/'.$qrcode_file;
                        $qrcode_path = SITE_DIR.$qrcode_file;
                        
                        $size = round($value['orgwidth']/25);//QRcode size计算
                        if($size<=0) $size =1;
                        if($value['orgtype']=='text')
                        {
                            \QRcode::png($qrcode, $qrcode_path, 'L',$size, 2);
                        }else if($value['orgtype']=='url')
                        {
                            \QRcode::png('url:'.$qrcode, $qrcode_path, 'L',$size, 2);
                        }else if($value['orgtype']=='tel')
                        {
                            \QRcode::png('tel:'.$qrcode, $qrcode_path, 'L',$size, 2);
                        }else
                        {
                            $qrcode_url = '';
                        }
                        
                    }
                    $return_data[$value['name']] =serialize(array(
                            'value'=>$qrcode,
                            'qrcode_url'=>$qrcode_url,
                        ));
                    break;
                case 'listctrl':

                    if(!$post_data[$value['name']][0])
                    {
                        $return_data[$value['name']] = '';
                        break;
                    }

                    $temparr = array();
                    //处理用户输入 

                   
                    $orgcoltype = trim($value['orgcoltype'],'`');
                    $orgsum = trim($value['orgsum'],'`');

                    $orgcoltype_arr = explode('`', $orgcoltype);
                    $orgsum_arr = explode('`', $orgsum);

                    $temparr_sum = array();//合计
                    foreach ($post_data[$value['name']][0] as $k => $val)
                    {
                        if($val=='') continue;

                        foreach ($post_data[$value['name']] as $k2 => $val2)
                        {
                           if($orgcoltype_arr[$k2]=='int')
                           {
                               $temparr[$k][$k2] = floatval($post_data[$value['name']][$k2][$k]);
                           }else
                           {
                               $temparr[$k][$k2]= $post_data[$value['name']][$k2][$k];
                           }

                           //合计
                            if($orgsum_arr[$k2]>0)
                            {
                                $temparr_sum[$k2] = $post_data[$value['name']][$k2]['total'];
                            }
                        }

                    }

                    $return_data[$value['name']] = serialize(array(
                        'list'=>$temparr,   //行数据
                        'sum'=>$temparr_sum,//合计
                    ));
                    break; 
                case 'text':
                case 'textarea':
                case 'radios':
                case 'select':
                case 'macros':
                case 'progressbar':
                default:
                    $return_data[$value['name']]= $post_data[$value['name']] ? trim($post_data[$value['name']]) : '';
            }
            
        }
        return $return_data;
    }
    
}
