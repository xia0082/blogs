<?php
include_once "main.php";
$selStr1 = "SELECT * FROM web";
$result=mysqli_query($con,$selStr1);
$page = $_POST["pages"];
$long = $_POST["longs"];
$nums = mysqli_num_rows($result);
$arry = [];
$pageArry = [];
while($rows = mysqli_fetch_assoc($result)){
	$arry[] = $rows;
}
for($i = $page * $long - $long ; $i <$nums && $i < $page * $long ; $i ++){
	$pageArry[] = $arry[$i];
}

@Response::json($pageArry,$nums);