<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库配置 */
    'DB_TYPE'   => 'mysqli', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'leipi_formdesign', // 数据库名
    'DB_USER'   => 'root', // 用户名
	'DB_PWD'    => '',  // 密码
    //'DB_PWD'    => 'RVBm7uzZQZZtKaxz',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'leipi_', // 数据库表前缀
    
    'DEFAULT_CHARSET' => 'utf-8', // 默认输出编码
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'TMPL_STRIP_SPACE'          => true,//debug时为false   去除html空白
    'DEFAULT_FILTER'        =>  'htmlspecialchars', // 默认参数过滤方法 用于I函数...  
    'DEFAULT_THEME' =>  'Default',  // 默认模板主题名称
    'DEFAULT_MODULE'     =>    'Home',
    'MODULE_ALLOW_LIST'  => array('Home','Admin'),//可访问的模块
    'MODULE_DENY_LIST'   => array('Common'),//不可访问
    'VAR_SESSION_ID'=>'PHPSESSID',//swfupload 上传时，可以设置 
    'URL_MODEL'=>3,
    /* 非官方 */
    'CSS_JS_VS'=>'2023',//版本号   用来刷新 js css 等缓存
    
);
