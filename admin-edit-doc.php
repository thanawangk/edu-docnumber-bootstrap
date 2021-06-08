<?php
require("dbConn.php");
session_start();
date_default_timezone_set("Asia/Bangkok");

$docid = $_GET["docid"];
$userid = $_SESSION['AD_userid'];

if (!$_SESSION['login']) {
    header("location: /myqnumber/login.php");
    exit;
}

$namearr = array('');
$selectuser = "select Name from type";
$reql = $db->query($selectuser);

while ($row = mysqli_fetch_array($reql)) {
    array_push($namearr, $row['Name']);
}

$nameadd = count($namearr);


$docid = $_GET["docid"];

$_SESSION['nameadd'] = $nameadd;

$selectresult = "select resultNumber from document where DocumentID='$docid'";
$reql = $db->query($selectresult);
$row = mysqli_fetch_array($reql);
$resultnum = $row['resultNumber'];

$selectnumbook = "select document.TypeID,type.TypeID,type.TypeNumber from type JOIN document ON type.TypeID = document.TypeID WHERE document.DocumentID = '$docid'";
$reql = $db->query($selectnumbook);
$row = mysqli_fetch_array($reql);
$typenum = $row['TypeNumber'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขเอกสาร</title>

    <link rel="stylesheet" href="/myqnumber/lib/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            height: 768px;
            background: linear-gradient(to right,
                    rgba(252, 108, 120, 0.9),
                    rgba(108, 247, 252, 0.9));
            font-family: 'Sarabun', sans-serif;
        }

        /* body {
            background-color: #08e1ae;
            background-image: linear-gradient(315deg, #08e1ae 0%, #98de5b 74%);
        } */
    </style>

</head>

<body>
    <section class="min-vh-100">

        <!-- หัวบนสุด -->
        <header class="py-1 mb-3 border-bottom bg-light">
            <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

                <a class="navbar-brand" href="#">
                    <!-- <img src="img/ku-sublogo.png" class="img-fluid" alt="" width="80" height="80"> -->
                    <span class="text-success">KU SRC</span>
                </a>

                <div class="d-flex align-items-center justify-content-end">
                    <div class="flex-shrink-0 dropdown ">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">

                            <?php
                            echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle img-responsive img-circle " width="32" height="32" /> &nbsp;';
                            echo  $_SESSION['user_first_name'];
                            ?>

                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <div class="container col-lg-8 bg-light p-3">

            <!-- Sidebar แบบสำรอง -->
            <!-- <div class="col-sm-3 col-md-3"> -->
            <!-- <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        <span class="fs-4">หน้าแรก</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">กรอกเอกสาร</a>
                        <a href="#" class="list-group-item list-group-item-action">กรอกย้อนหลัง</a>
                        <a href="#" class="list-group-item list-group-item-action">ประเภทหนังสือ</a>
                        <a href="#" class="list-group-item list-group-item-action">จัดการสมาชิก</a>
                        <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">บ่มี</a>
                    </div> -->
            <!-- </div> -->

            <!-- ล่างหัวบน -->
            <div class="ku-header p-1 pb-md-4 mx-auto text-center">
                <h1 class="display-4 fw-normal">KASETSART UNIVERSITY </h1>
            </div>

        </div>

        <!-- แถบเมนู2 -->
        <div class="container col-lg-8 alert-secondary">
            <header class="p-3 mb-1 mt-1 border-bottom alert-secondary">
                <div class="container">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="admin-home.php" class="nav-link px-2 link-secondary">Home</a></li>
                        <li><a href="admin-form-doc.php" class="nav-link px-2 link-dark">กรอกขอเลข</a></li>
                        <li><a href="admin-reform-doc.php" class="nav-link px-2 link-dark">กรอกย้อนหลัง</a></li>
                        <li><a href="admin-booktype.php" class="nav-link px-2 link-dark">ประเภทหนังสือ</a></li>
                        <li><a href="admin-users.php" class="nav-link px-2 link-dark">จัดการสมาชิก</a></li>
                    </ul>
                </div>
            </header>
        </div>


        <div class="container col-lg-8 bg-light p-3">



        </div>





    </section>







    <script src="/myqnumber/lib/bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>