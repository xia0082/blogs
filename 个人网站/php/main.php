<?php
// 设置编码
	header("Content-Type:text/html;charset=utf-8");
	// 服务器地址
	$servername="localhost";
	// 服务器账号
	$username="root";
	// 服务器密码
	$password="";
	// 数据库名字
	$dbname="grwz";
	// 连接数据库
	$con = mysqli_connect($servername,$username,$password);
	if(!$con){
	    echo "数据库连接失败！";
	}
	mysqli_set_charset($con,"utf8");
//	 选择连接的数据库名
	mysqli_select_db($con,$dbname);
	// 构造返回数据的类
	class Response{
		// 声明一个公共静态方法:重组查询到的数据
		public static function json($data=array(),$nums){
			$result=array(
			  // 状态码
			
			  // 查询到的具体数据
			  'data'=>$data,
			  'nums' =>$nums
			);
			//输出json
			echo JSON_encode($result,JSON_UNESCAPED_UNICODE);

			exit;
		}
	}