<?php
header("content-type:text/json;charset=utf-8");
define("HOST","127.0.0.1");
define("USERNAME","root");
define("PWD","");
define("CHARSET","utf8");
$db = mysqli_connect(HOST,USERNAME,PWD) or die("数据库连接失败,<span style='color:red';>".mysqli_error()."</span>");
if(date_default_timezone_get() != "1Asia/Shanghai") date_default_timezone_set("Asia/Shanghai");
mysqli_set_charset($db,CHARSET);
// 定义操作数据库的类
/**
 * 定义操作数据库的类
 * 除返回json方法可以直接通过(类名::方法)调用,其余方法都必须在实例化该对象或添加 mysqli_select_db()方法的前提下使用
 */
class Operate
{
    public $db;
    public $name;
    public $arry;
    public $tabName;
    /**
     * 创建数据库
     * $name: 数据库名
     */
    function __construct($name){
        // 传入连接好的数据库
        $this -> db = $GLOBALS['db'];
        $this -> name = $name;
        // 检测并创建有无对应数据库
        $create = "CREATE DATABASE IF NOT EXISTS $name";
        mysqli_query($this -> db, $create);
        mysqli_select_db($this -> db, $name);
    }
    // 创建数据表
    /**
     * $tabName: 数据表名
     * $obj: 插入的表头,key为表头名,value为表头类型
     */
    function table($tabName, $obj){
        $tab = "CREATE TABLE $tabName( id INT NOT NULL AUTO_INCREMENT, ";
        foreach ($obj as $key => $value) {
            $tab .= "$key $value NOT NULL, ";
        }
        $tab .= 'PRIMARY KEY(id)) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        mysqli_query($this -> db, $tab);
        $this -> tabName = $tabName;
        foreach ($obj as $key => $value) {
            $this -> arry[] = $key;
        }
    }
    /**
     * 插入数据
     * $ary: 数组(包含要插入的类别对应的值)
     * $tabName: 数据表名;如不是半截调用,无需填写
     */
    function insert($ary,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $this -> thead();
        $insert = "INSERT INTO ".$this -> tabName.'(';
        for ($i=1; $i < count($this -> arry); $i++) {
            $insert .= $this -> arry[$i];
            if ($i < count($this -> arry) - 1) $insert .= ', ';
        }
        $insert .= ") VALUES ('";
        for ($j=0; $j < count($ary); $j++) {
            $insert .= $ary[$j]."'";
            if ($j < count($ary) - 1) $insert .= ", '";
        }
        $insert .= ')';
        $state =mysqli_query($this -> db, $insert);
    }
    /**
     * 查询数据表
     * $ary: 数组(包含要查询的类别)
     * $tabName: 数据表名;如不是半截调用,无需填写
     */
    function search($ary,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $search = "SELECT ";
        for ($i=0; $i < count($ary); $i++) {
            $search .= $ary[$i];
            if ($i < count($ary) - 1) $search .= ", ";
        }
        $search .= " FROM ".$this -> tabName;
        $result = mysqli_query($this -> db, $search);
        $arry = [];
        while($row = mysqli_fetch_assoc($result)){
            $arry[] = $row;
        }
        return $arry;
    }
    /**
     * 查询指定的数据
     * $ary: 数组(包含要查询的类别)
     * $key: 指定类别('字符串');
     * $value: 指定类别值('字符串');
     */
    function searchVal($ary,$key,$value,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $search = "SELECT ";
        for ($i=0; $i < count($ary); $i++) {
            $search .= $ary[$i];
            if ($i < count($ary) - 1) $search .= ", ";
        }
        $search .= " FROM ".$this -> tabName." WHERE $key = '$value'";;
        $result = mysqli_query($this -> db, $search);
        $arry = [];
        if ($result) {
            while($row = mysqli_fetch_assoc($result)){
                $arry[] = $row;
            }
        }
        return $arry;
    }
    /**
     * 查询指定下标的数据
     * $ary: 数组(包含要查询的类别)
     * $num: 指定下标
     * $tabName: 数据表名;如不是半截调用,无需填写
     */
    function searchSub($ary,$num,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $search = "SELECT id,";
        for ($i=0; $i < count($ary); $i++) {
            $search .= $ary[$i];
            if ($i < count($ary) - 1) $search .= ", ";
        }
        $search .= " FROM ".$this -> tabName;
        $result = mysqli_query($this -> db, $search);
        $autoName = 0;
        while($row = mysqli_fetch_assoc($result)){
            $autoName++;
            if ($autoName == $num) {
                $id = $row['id'];
                $newStr = $search." WHERE id = '$id'";
                $newRes = mysqli_query($this -> db, $newStr);
            }
        }
        $arry = [];
        while($row = mysqli_fetch_assoc($newRes)){
            $arry[] = $row;
        }
        return $arry;
    }
    /**
     * 按下表删除数据表
     * $num: 为要删除的下标
     */
    function deleteSub($num,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $this -> thead();
        $search = "SELECT ";
        for ($i=0; $i < count($this -> arry); $i++) {
            $search .= $this -> arry[$i];
            if ($i < count($this -> arry) -1) $search .= ", ";
        }
        $search .= ' FROM '.$this -> tabName;
        $result = mysqli_query($this -> db, $search);
        $autoName = 0;
        while($row = mysqli_fetch_assoc($result)){
            $autoName++;
            if ($autoName == $num) {
                $id = $row['id'];
                $delStr = "DELETE FROM ".$this -> tabName." WHERE id = '$id'";
                mysqli_query($this -> db, $delStr);
            }
        }
    }
    /**
     * 按条件删除
     * obj: key为查询类别,value为要删除的对应的值
     */
    function deleteTerm($obj,$tabName=null){
        if(!is_null($tabName)) $this -> tabName = $tabName;
        $this -> thead();
        $search = "SELECT ";
        for ($i=0; $i < count($this -> arry); $i++) {
            $search .= $this -> arry[$i];
            if ($i < count($this -> arry) -1) $search .= ", ";
        }
        $search .= 'FROM '.$this -> tabName;
        $result = mysqli_query($this -> db, $search);
        foreach ($obj as $key => $value) {
            $delStr = "DELETE FROM ".$this -> tabName." WHERE $key = '$value'";
            mysqli_query($this -> db, $delStr);
        }
    }
    /**
     * 返回json
     * $code: 状态码
     * $message: 信息
     * $data: 数据
     */
    function json($code="",$message="",$data=array()){
        $result = array(
            // 状态码
            'code' => $code,
            // 提示信息
            'message' => $message,
            // 查询到的具体数据
            'data' => $data,
            // 总数据量
            'num' => count($data)
        );
        //输出json
        // echo json_encode($result);
        // JSON_UNESCAPED_UNICODE(中文不转为unicode,对应的数字 256)
        // JSON_UNESCAPED_SLASHES(不转义反斜杠,对应的数字 64)
        // 同时使用两个常量(对应数字 256+64=320)
        echo json_encode($result,320);
        exit;
    }
    // 查询数据表表头
    public function thead(){
        $sql = "select * from ".$this -> tabName;
        $this -> arry = [];
        $res = mysqli_query($this -> db, $sql);
        while($tab = mysqli_fetch_field($res)){
            array_push($this -> arry, $tab->name);
        }
    }
}