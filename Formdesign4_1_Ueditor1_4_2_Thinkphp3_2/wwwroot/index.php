<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
header("Content-type: text/html; charset=utf-8");
//##################  Start 非官方 ###################################
//网站根域名
 define('SITE_URL',     'http://'.$_SERVER['HTTP_HOST']);
//入口文件 根目录
 define('SITE_DIR',     __DIR__.'/');
 //定义时间
define ( 'TIMESTAMP', time() );
//##################  End 非官方 ###################################

/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define ( 'APP_PATH', '../Application/' );
/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define ( 'RUNTIME_PATH', APP_PATH.'Runtime/' );
/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define ( 'APP_DEBUG', true );
/**
 * 引入核心入口
 * ThinkPHP亦可移动到WEB以外的目录
 */
require '../ThinkPHP/ThinkPHP.php';
?>
