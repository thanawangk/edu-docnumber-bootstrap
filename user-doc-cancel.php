<?php
session_start();
require("dbConn.php");
if($_SESSION["USE_userid"]=="" || $_SESSION["USE_name"]=="" || $_SESSION["USE_email"]==""){
  header("location: login.php");  
}else{
    
    $docid = $_GET["docid"];
    
    if($docid!=""){
        $cancelsql = "update document set 
        Status = '0'
        where DocumentID = '".$docid."'
        ";
        
        if($db->query($cancelsql)==TRUE){
            echo "<script>";
            echo "alert('ยกเลิกข้อมูลเอกสารแล้ว');"; 
            echo "window.location.href = 'user-home.php';";
            echo "</script>"; 
        }else{
            echo "<script>";
            echo "alert('ไม่สามารถลบได้ เกิดข้อผิดพลาด');"; 
            echo "window.location.href = 'user-home.php';";
            echo "</script>";  
        }
    }else{
        header("location: user-home.php");
    }

} ?>