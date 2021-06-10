<?php
session_start();
require("dbConn.php");
if($_SESSION["AD_userid"]=="" || $_SESSION["AD_name"]=="" || $_SESSION["AD_email"]==""){
  header("location: login.php");  
}else{
    $typeid = $_GET["typeid"];

    if($typeid!=""){
        $deletesql = "delete from type where TypeID = '".$typeid."'";
        
        if($db->query($deletesql)==TRUE){
            echo "<script>";
            echo "alert('ลบประเภทหนังสือแล้ว');"; 
            echo "window.location.href = 'admin-booktype.php';";
            echo "</script>"; 
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้ เกิดข้อผิดพลาด');"; 
            echo "window.location.href = 'admin-booktype.php';";
            echo "</script>";  
        }
    }else{
        header("location: admin-booktype.php");
    }

} ?>