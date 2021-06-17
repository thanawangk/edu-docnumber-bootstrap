<?php
    include "dbConn.php";
    session_start();
    $starindex = 2;
    $chkid = 1;
    $userid = $_SESSION["userid"];
    $newword = array('');
    $ii = 1;
    
    $selectuser = "select * from user where UserID = $userid";
    $reql = $db->query($selectuser);
    $rowuser = $reql->fetch_assoc();

    $fullname = $_POST['Name'];
    $surname = $_POST['Surname'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];

    if($_POST['Name'] == '')
    {
        $fullname = $rowuser["Name"];
    }

    if($_POST['Surname'] == '')
    {
        $surname = $rowuser["Surname"];
    }

    if($_POST['Email'] == '')
    {
        $email = $rowuser["Email"];
    }
    if($_POST['Phone'] == '')
    {
        $phone = $rowuser["Phone"];
    }

    if(isset($_POST['radio1']))
    {
        $radi = $_POST['radio1'];
    }
    if(isset($_POST['radio2']))
    {
        $radi = $_POST['radio2'];
    }

    if(!isset($radi))
    {
        $radi = 'admin';
    }

    $countloop = 1;
    if($radi == 'admin'){
        $selecttype = "select * from type";
        $reql = $db->query($selecttype);
        $nameadd = $reql->num_rows+1;
        while($countloop < $nameadd){
            array_push($newword,$countloop);
            $countloop += 1;
        }  
    }
    else{
        $selecttype = "select * from type";
        $reql = $db->query($selecttype);
        $nameadd = $reql->num_rows+1;
        while($ii < $nameadd)
        {
            if(isset($_POST['chk'.$chkid])){
                $ina = $_POST['chk'.$chkid];
                array_push($newword,$ina);
            }
            $ii += 1;
            $chkid += 1;
        }
    }
    $cnew = count($newword);

    $cleanuser = "delete from permission where UserID = '".$userid."'";
    if ($reql = $db->query($cleanuser)) {
        #echo "Record clea successfully<br>";
    }

    $ii = 1;
    $countloop = 1;
    while($countloop < $cnew)
    {
        $insert = mysqli_query($db,"INSERT INTO `permission`(`UserID`,`TypeUseID`) VALUES ('$userid','$newword[$countloop]')");
        $countloop += 1;
    }

    $selectuser = "update user set Status = '$radi',Name = '$fullname',Surname ='$surname',Email='$email',Phone = '$phone' where UserID = '$userid'";

    if ($reql = $db->query($selectuser)) {
        #echo "Record updated successfully<br>";
    }



    header("location: admin-users.php");



?>