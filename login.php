<?php
include('config.php');
require("dbConn.php");

date_default_timezone_set("Asia/Bangkok");
$selectnow = "select yearnow from now where now_id = '1'";
$reql = $db->query($selectnow);
$rowyear = $reql->fetch_assoc();
$date_y = (date("Y") + 543);
$date_d = date("d-m");

if (!isset($rowyear['yearnow'])) {
    $insert = mysqli_query($db, "INSERT INTO `now`(`now_id`,`yearnow`) VALUES ('1','$date_y')"); # work line
    #$insert = mysqli_query($db, "INSERT INTO `now`(`now_id`,`yearnow`) VALUES ('2','$date_d')");
}

// type
$selecttype = "select TypeID from type where status=1 ";
$typemax = $db->query($selecttype);


while ($typem = $typemax ->fetch_assoc() ){


    $TypeRT = $typem["TypeID"];

    
    
    
}

// echo "$TypeRT*int(3)  <br>";

// $intTypeRT = (int)$TypeRT*3;
$intTypeRT = 1;
// echo "$intTypeRT TRT <br>";


// type



$selectdoc = "select Date from document where status=1 ";
$datecheck = $db->query($selectdoc);


while ($checkD = $datecheck->fetch_assoc() ){


    $dateRT = $checkD["Date"];

    
    
    
}
// $date_c = date("m-d");
// $date_d = date("d");
// $date_check = $date_y."-".$date_c;
// // echo "$date_d <br>";
// // echo substr("$date_d",0);
// echo  "<br>";
// echo "$dateRT <br>";
// echo "$date_check<br>";
// $zero = 0;
// $conn = new mysqli("localhost","root","","qnumber");


// if($date_check != $dateRT){
//     echo "insert <br>";
//     while($zero<$intTypeRT){
//         $zero+=1;
//         // insert status 4
//         //  $insertreform = "INSERT INTO `document` (`DocumentID`, `TypeID`, `UserID`, `Date`, `resultNumber`, `Sent_Name`, `Receive_Name`, `Text`, `Phone`, `Filee`, `Status`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
//         $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";
//         // $sql = "INSERT INTO `document` ( `Status`) VALUES (2)";

//         $result = $conn->query($sql);
//     }
// }
// else{
//     echo "no insert";
// }







$selectnow = "select yearnow from now where now_id = '1'";
$reql = $db->query($selectnow);
$rowyear = $reql->fetch_assoc();
$date_y = (date("Y") + 543);





#chack old year  ?
if ($rowyear['yearnow'] != $date_y) {
    $selecttype = "select * from type";
    if ($reql = $db->query($selecttype)) {
        $round = $reql->num_rows + 1;
        $updatedoc = "update now set yearnow = '$date_y' where now_id = '1'";
        $reql = $db->query($updatedoc);
        $i = 1;
        while ($i < $round) {
            $updatetype = "update type set current_number = '0',current_year = '$date_y' where TypeID = '$i'";
            if ($reql2 = $db->query($updatetype)) {
                #echo "update type new year";
            }
            $i += 1;
        }
    } else {
        print_r('book emtry');
    }
}
unset($namearr);
unset($numberarr);

$login_button = '';

if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }
        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }
        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }
        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }
        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
        //ตัวแปรไว้ใช้เช็คการ login
        $_SESSION['login'] = true;
    }
}

if (!isset($_SESSION['access_token'])) {

    $login_button = '<a href="' . $google_client->createAuthUrl() . '"class="btn btn-outline-dark" style="text-transform:none"><img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />Login With Google</a>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    <link rel="stylesheet" href="/myqnumber/lib/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">
    <style>
        body {

            background: linear-gradient(to right,
                    #164A41, #4D774E, #9DC88D);
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body class="text-center">


    <div class="row">

    </div>
    <!--   start Container    -->
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-8 col-md-9">

                <!-- ส่วนของ Card -->
                <div class="card border-0 shadow-lg my-5">
                    <div class="card-body p-4">



                        <!-- <img class="img-fluid" src="img/ku-logo1.png" alt="" > -->
                        <img class="img-responsive rounded mb-3" src="img/ku-logo1.png" alt="">



                        <div class="fs-2 text-gray-900 mb-4 ">ระบบออกเลขหนังสือราชการ</div>
                        <p class="h6 text-muted mb-4 pt-4">โปรดเข้าสู่ระบบด้วยแอคเคาท์ @eng.src.ku.th เท่านั้น</p>

                        <?php

                        if ($login_button == '') {
                            header('location:ckuser.php');
                        } else {
                            echo '<div align="center">' . $login_button . '</div>';
                        }
                        ?>



                    </div>
                </div>
                <!-- จบส่วน Card -->

            </div>
        </div>
    </div>
    <!-- end Container    -->

    <p class="mt-5 mb-3">&copy; 2021–20XX</p>

    <script src="/myqnumber/lib/bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>