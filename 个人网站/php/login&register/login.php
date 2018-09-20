<?php
include_once '../index.php';
$oper = new Operate('grwz');
class Obj{
	public $user = 'VARCHAR(1000)';
    public $pwd = 'VARCHAR(1000)';
}
$obj = new Obj;
$oper -> table('person',$obj);
$ren = $_POST['user'];
$mima = $_POST['pwd'];
$yonghu = $oper -> searchVal(array($ren,$mima),"user","$ren");
if(count($yonghu)){
	$oper->json('200','用户已存在');
}else{
	$oper -> insert(array($ren,$mima));
	$oper ->json('200','注册成功');
}
