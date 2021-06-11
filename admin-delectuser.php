<?php
session_start();
require("dbConn.php");
if($_SESSION["AD_userid"]=="" || $_SESSION["AD_name"]=="" || $_SESSION["AD_email"]==""){
  header("location: index.php");  
}else{
    $userid = $_GET["userid"];

    if($userid!=""){
        $deletesql = "delete from user where UserID = '".$userid."'";
        $deletesql1 = "delete from permission where UserID = '".$userid."'";
        if($db->query($deletesql)==TRUE and $db->query($deletesql1)==TRUE){
            echo "<script>";
            echo "alert('ลบบัญชีผู้ใช้งานแล้ว');"; 
            echo "window.location.href = 'admin-users.php';";
            echo "</script>"; 
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้ เกิดข้อผิดพลาด');"; 
            echo "window.location.href = 'admin-users.php';";
            echo "</script>";  
        }
    }else{
        header("location: admin-users.php");
    }

} ?>