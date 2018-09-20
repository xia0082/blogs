<?php
include_once '../main.php';
$user = $_POST['user'];
$pwd = $_POST['pwd'];
$sqlStr =<<<sql1
SELECT user FROM person WHERE user="$user";
sql1;
$res1 = mysqli_query($con, $sqlStr);
if(mysqli_num_rows($res1)>0){
	die("登录成功");
}else{
	die("账号密码错误");
}

