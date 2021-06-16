<?php
session_start();
require("dbConn.php");
if($_SESSION["AD_userid"]=="" || $_SESSION["AD_name"]=="" || $_SESSION["AD_email"]==""){
  header("location: login.php");  
}else{
    $docid = $_GET["docid"];
    
    if($docid!=""){
        $cancelsql = "update document set 
        Status = '1'
        where DocumentID = '".$docid."'
        ";
        
        if($db->query($cancelsql)==TRUE){
            echo "<script>";
            echo "alert('ใช้งานข้อมูลเอกสารแล้ว');"; 
            echo "window.location.href = 'admin-home.php';";
            echo "</script>"; 
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถใช้งานได้ เกิดข้อผิดพลาด');"; 
            echo "window.location.href = 'admin-home.php';";
            echo "</script>";  
        }
    }else{
        header("location: admin-home.php");
    }

} ?>