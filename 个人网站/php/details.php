<?php
include_once "main.php";
$id = $_POST["id"];
$sql = "SELECT * FROM web WHERE id = $id";
$result = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($result)){
	$data = array();
	$data["id"] = $row["id"];
	$data["title"] = $row["title"];
	$data["photo"] = $row["photo"];
	$data["content"] = $row["content"];
	$data["time"] = $row["time"];
}
$json = json_encode($data);
echo $json;
