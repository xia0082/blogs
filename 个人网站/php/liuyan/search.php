<?php
include_once "../index.php";

$oper = new Operate('grwz');
// 查询数据
$arry = $oper -> search(array('name','text','url','time'),'language');
$oper -> json('200','成功',$arry,count($arry));