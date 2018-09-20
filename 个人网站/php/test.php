<?php
include_once 'index.php';
var_dump($_POST);
// 测试
$oper = new Operate('grwz');
// 创建数据表中的表头参数
class Obj
{
    public $title = 'VARCHAR(1000)';
    public $photo = 'VARCHAR(1000)';
    public $content = 'VARCHAR(1000)';
    public $time = 'VARCHAR(1000)';
}
$obj = new Obj;
$oper -> table('web',$obj);
$title = $_POST['title'];
$photo = $_POST['photo'];
$content = $_POST['content'];
date_default_timezone_set('PRC');
$time = date('Y-m-d h:i',time());
$oper -> insert(array($title,$photo,$content,$time));