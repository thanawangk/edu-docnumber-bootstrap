<?php
session_start();
require("dbConn.php");

$name = $_SESSION['user_first_name'];
$email = $_SESSION['user_email_address'];

    // เช็คจาก ชื่อ และ อีเมล
    $ckmember = "select Name,UserID,Status,Email,Surname from user where Name = '".$name."' and Email = '".$email."'";
    $result = $db->query($ckmember);
    $row = $result->fetch_assoc();
    

    if(isset($row["Name"])!=""){
        $_SESSION['statusfor'] = $row["Status"];
        if($row["Status"]=="user"){
            $_SESSION["USE_userid"] = $row["UserID"];
            $_SESSION["USE_name"] = $row["Name"];
            $_SESSION["USE_email"] = $row["Email"];
            $_SESSION['USE_status'] = $row["Status"];
            echo "<script>";
            echo "alert('ยินดีต้อนรับ Member คุณ $name');";
            echo "window.location.href = 'user-home.php';";
            echo "</script>"; 
        }else{
            $_SESSION["AD_userid"] = $row["UserID"];
            $_SESSION["AD_name"] = $row["Name"];
            $_SESSION["AD_email"] = $row["Email"];
            $_SESSION['AD_status'] = $row["Status"];
            echo "<script>";
            echo "alert('ยินดีต้อนรับ Admin คุณ $name');"; 
            echo "window.location.href = 'admin-home.php';";
            echo "</script>"; 
        }
    }else{
      echo "<script>";
      echo "alert('บ่มี ชื่อผู้ใช้งานหรือรหัสผ่านผิด');"; 
      echo "window.history.back()";
      echo "</script>";  
    }



?>