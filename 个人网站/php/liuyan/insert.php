<?php
include_once '../index.php';
header("Content-Type:textml;charset=utf-8");
var_dump($_POST);
// 测试
$oper = new Operate('grwz');
// 创建数据表中的表头参数
class Obj
{
    public $name = 'VARCHAR(1000)';
    public $text = 'VARCHAR(1000)';
    public $url = 'VARCHAR(1000)';
    public $time = 'VARCHAR(1000)';
}
$obj = new Obj;
$oper -> table('language',$obj);
$name = $_POST['name'];
$text = $_POST['text'];
$url = $_POST['url'];
date_default_timezone_set('PRC');
$time = date('Y-m-d h:i',time());
$oper -> insert(array($name,$text,$url,$time));

