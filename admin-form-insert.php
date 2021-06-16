<?php
include "dbConn.php"; // Using database connection file here
session_start();
date_default_timezone_set("Asia/Bangkok");

$nameadd = $_SESSION['nameadd'];
if(isset($_POST['submit']))
{
    $namepdf ="";
    $typefile = $_FILES["fileUpload"]["type"];
    if($_FILES['fileUpload']['size'] != 0)
    {
        $namepdf = $_FILES["fileUpload"]["name"];
    }    

    if(isset($_POST['type_id']))
    {
        $dropdown = $_POST['type_id'];
    }


    $sead = $_POST['send'];
    $to = $_POST['to'];
    $story = $_POST['story'];
    
    $date = $_POST['date'];

    $time = date('Y-m-d H:i:s',strtotime($_POST['date']));
    $userid = $_SESSION['AD_userid'];

    $filee = $namepdf;
    $resultNumber = 1;

    $selecttype = "select current_number from type where TypeID = '$dropdown'";
    $reql = $db->query($selecttype);
    $rowtype = $reql->fetch_assoc();
    $resultNumber = $rowtype['current_number'] + 1;
    $checky = date('Y')+543; 


    if($_FILES['fileUpload']['size'] != 0 and $typefile == 'application/pdf')
    {
        $insert = mysqli_query($db,"INSERT INTO `document`(`TypeID`,`UserID`,`Date`,`resultNumber`,`Sent_Name`,`Receive_Name`,`Text`,`Filee`,`Status`) VALUES ('$dropdown','$userid' ,'$time','$resultNumber','$sead','$to','$story','$filee','1')");
        $namearr = array('');
        $selectdoc = "select MAX(DocumentID) from document where Sent_Name = '$sead' AND TypeID = '$dropdown'";
        $reql = $db->query($selectdoc);
        $rowdoc = $reql->fetch_assoc();
        $newnamefile = $rowdoc['MAX(DocumentID)'];
        $updatefile = "update document set Filee = '$newnamefile.pdf'  where DocumentID = '$newnamefile'"; 
        if ($reql = $db->query($updatefile)) {
            echo " updated file name successfully<br>";
        }   

        $destination = 'uploads/'.$rowdoc['MAX(DocumentID)'].'.pdf';
        $extension = pathinfo($namepdf, PATHINFO_EXTENSION);
        $size = $_FILES['fileUpload']['size'];
        $file = $_FILES['fileUpload']['tmp_name'];
        if (!in_array($extension, ['pdf', 'docx'])) {
            echo "You file extension must be .zip, .pdf or .docx";
        } else {
            if (move_uploaded_file($file, $destination)) {
                    echo "File uploaded successfully";
                }
            else {
                echo "Failed to upload file.";
            }
        }
    }else{
        $insert = mysqli_query($db,"INSERT INTO `document`(`TypeID`,`UserID`,`Date`,`resultNumber`,`Sent_Name`,`Receive_Name`,`Text`,`Status`) VALUES ('$dropdown','$userid' ,'$time','$resultNumber','$sead','$to','$story','1')");
    }

    $updatetype = "update type  set current_number = '$resultNumber' where TypeID = '$dropdown' AND current_year = '$checky'"; 
    if ($reql = $db->query($updatetype)) {
        echo "Record updated successfully<br>";
    }


mysqli_close($db); 
header("location: admin-home.php");
}
?>