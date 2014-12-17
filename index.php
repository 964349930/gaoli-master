<?php
/**
 * 入口文件
 * @author chen
 * @version 2014-03-11
 */
//设置项目名称和路径
define('APP_NAME', 'app');
define('APP_PATH', './app/');

//开启调试模式
define('APP_DEBUG', true);

//加载框架入口文件
require( './core/ThinkPHP/ThinkPHP.php');
?>