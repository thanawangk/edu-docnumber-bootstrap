<?php
include "dbConn.php"; 
session_start();
$selecttype = "select * from type";
$reql = $db->query($selecttype);
$addnum = $reql->num_rows+1;

if(isset($_POST['submit']))
{	
    $fullname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $email = $_POST['ename'];
    $phonenum = $_POST['phonenum'];

    if(isset($_POST['radio1']))
    {
        $ral1 = $_POST['radio1'];
    }

    if(isset($_POST['radio2']))
    {
        $ral1 = $_POST['radio2'];
    }

    if(!isset($ral1))
    {
        $ral1 = 'admin';
    }

    $countloop = 1;
    $newword = array('');
    if($ral1 == 'admin'){
        while($countloop < $addnum){
            array_push($newword,$countloop);
            $countloop += 1;
        }  
    }

    else{
        while($countloop < $addnum){
            if(isset($_POST['chk'.$countloop])){
                $ina = $_POST['chk'.$countloop];
                array_push($newword,$ina);
            }
            $countloop += 1;
        }
    }
    
    $cnew = count($newword);

    
    $insert = mysqli_query($db,"INSERT INTO `user`(`Status`,`Name`,`Surname`,`Email`,`Phone`) VALUES ('$ral1','$fullname','$lastname','$email','$phonenum')");
    $sql = "SELECT UserID FROM user WHERE Email='$email' ";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $useradd = $row["UserID"];
        }
    }
    $countloop = 1;
    print_r($newword);
    while($countloop < $cnew)
    {
        $insert = mysqli_query($db,"INSERT INTO `permission`(`UserID`,`TypeUseID`) VALUES ('$useradd','$newword[$countloop]')");
        $countloop += 1;
    }
    
    


}
header("location: admin-users.php");
mysqli_close($db); // Close connection

?>
