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
    $time1 = date('Y-m-d ',strtotime($_POST['date']));
    // print_r($time1);
    $userid = $_SESSION['AD_userid'];

    $filee = $namepdf;
    $resultNumber = 1;

    // $selecttype = "select current_number from type where TypeID = '$dropdown'";
    $selecttype = "select MAX(resultNumber) AS resultNumber from document where TypeID = '$dropdown' AND Date = '$time1'";

    $reql = $db->query($selecttype);
    $rowtype = $reql->fetch_assoc();
    // print_r($rowtype);
    $resultNumber = $rowtype['resultNumber'] ;
    // echo "<script type='text/javascript'>alert('$resultNumber');</script>";

    $selecttype1 = "select current_number from type1 where TypeID = '$dropdown'";
    // print_r($dropdown);
    $reql1 = $db->query($selecttype1);
    $rowtype1 = $reql1->fetch_assoc();
    $resultNumber1 = $rowtype1['current_number'] + 1;
    $checky = date('Y')+543; 
    $x = explode(".",strval($resultNumber))[0];
    // print_r($x);
    if($x != ""){
        $num = $resultNumber1 ;
        $newSelecttype =explode(".",strval($resultNumber))[0].".".strval($resultNumber1);
    }
    else{
        $num = 0 ;
        $newSelecttype = "1";
    }
    
    print_r($newSelecttype );

    if($_FILES['fileUpload']['size'] != 0 and $typefile == 'application/pdf')
    {
        $insert = mysqli_query($db,"INSERT INTO `document`(`TypeID`,`UserID`,`Date`,`resultNumber`,`Sent_Name`,`Receive_Name`,`Text`,`Filee`,`Status`) VALUES ('$dropdown','$userid' ,'$time','$resultNumber1','$sead','$to','$story','$filee','1')");
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
        $insert = mysqli_query($db,"INSERT INTO `document`(`TypeID`,`UserID`,`Date`,`resultNumber`,`Sent_Name`,`Receive_Name`,`Text`,`Status`) VALUES ('$dropdown','$userid' ,'$time','$newSelecttype','$sead','$to','$story','1')");
    }
    // $num = $resultNumber1 ;
    
    $updatetype = "update type1  set current_number = '$num' where TypeID = '$dropdown' AND current_year = '$checky'"; 
    
    if ($reql = $db->query($updatetype)) {

        echo "Record updated successfully<br>";
    }


mysqli_close($db); 
header("location: admin-home.php");
}
?>
