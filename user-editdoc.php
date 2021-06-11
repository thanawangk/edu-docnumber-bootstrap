<?php
require("dbConn.php");
session_start();
date_default_timezone_set("Asia/Bangkok");

// if (!$_SESSION['login']) {
//     header("location: /myqnumber/login.php");
//     exit;
// }

$docid = $_GET["docid"];

$userid = $_SESSION['USE_userid'];

$namearr = array('');
$selectuser = "select Name from type";
$reql = $db->query($selectuser);

while ($row = mysqli_fetch_array($reql)) {
    array_push($namearr, $row['Name']);
}

$nameadd = count($namearr);
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

    <link rel="stylesheet" href="css/ss3.css">
    <link rel="stylesheet" href="/myqnumber/lib/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&family=Shadows+Into+Light&display=swap" rel="stylesheet">


    <style>
        body {
           
           background: linear-gradient(to right,
           #12343b,#2d545e, #9DC88D);
           font-family: 'Sarabun', sans-serif;
       }
    </style>

</head>

<body>
    <!-- ส่วน Section -->
    <section class="min-vh-100">

        <!-- หัวบนสุด -->
        <header class="py-1 mb-3 border-bottom bg-light">
            <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">

                <a class="navbar-brand" href="#">
                    <img src="img/ku-sublogo.png" class="img-responsive" alt="" width="32" height="32">
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
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>
                                    สถานะ : <?php
                                            if ($_SESSION['statusfor'] == 'user') {
                                                echo "ผู้ใช้";
                                            }
                                            if ($_SESSION['statusfor'] == 'admin') {
                                                echo "แอดมิน";
                                            }
                                            ?>
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- ล่างหัวบน -->
        <div class="container col-lg-8 bg-light p-3">
            <div class="ku-header p-1 pb-md-4 mx-auto text-center">
                <h1 class="display-4 fw-normal">KASETSART UNIVERSITY </h1>
            </div>
        </div>

        <!-- แถบเมนู -->
        <div class="container col-lg-8 alert-secondary">
            <header class="p-3 mb-1 mt-1 border-bottom alert-secondary">
                <div class="container">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="user-home.php" class="nav-link px-2 link-secondary">หน้าแรก</a></li>
                        <li><a href="user-form.php" class="nav-link px-2 link-dark">กรอกขอเลข</a></li>
                        <li><a href="user-booktype.php" class="nav-link px-2 link-dark">ประเภทหนังสือ</a></li>
                    </ul>
                </div>
            </header>
        </div>

        <!-- เนื้อหา -->
        <div class="container col-lg-8 mb-3 bg-light p-3 pt-4 pb-4">

            <!-- การ์ด -->
            <div class="card ">
                <div class="card-header">
                    <h3>แก้ไขเอกสาร</h3>
                </div>
                <div class="card-body ps-4 pe-4">

                    <!-- ฟอร์ม -->

                    <form class="needs-validation" action="user-editdoc-update.php?docid=<?php echo $docid;?>" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">

                            <div class="container">

                            </div>

                            <div class="col-lg-4 col-md-4 ">
                                <label for="zip" class="form-label">เลขเอกสาร</label>
                                <input type="text" class="form-control" id="zip" value="อว.6503/<?php echo $typenum ;?>/<?php echo $resultnum;?>" readonly>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="firstName" class="form-label">ลงวันที่</label>
                                <div class="input-group has-validation">
                                <?php
                                    $selectdoc = "select * from document where DocumentID = '".$docid."'";
                                    $reql = $db->query($selectdoc);
                                    $rowdoc = $reql->fetch_assoc();
                                    $print_date = $rowdoc["Date"];
                                    $print_sentname= $rowdoc["Sent_Name"];
                                    $print_rename = $rowdoc["Receive_Name"];
                                    $print_text = $rowdoc["Text"];

                                    echo "<input type='text' class='form-control' id='zip' name='date' value='$print_date' required readonly>";
                                ?>
                                    <div class="invalid-feedback">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="firstName" class="form-label">ชื่อผู้ส่ง</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="send" id="firstName" value="<?php echo $print_sentname ?>" >
                                    <span class="input-group-text">ถึง</span>
                                    <div class="invalid-feedback">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="lastName" class="form-label">ชื่อผู้รับ</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="to" id="lastName" value="<?php echo $print_rename ?>" >
                                    <div class="invalid-feedback">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <label for="address" class="form-label">เรื่อง</label>
                                <textarea type="text" class="form-control" name="story" id="address"  ><?php echo $print_text ?></textarea>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>


                        </div>


                        <div class="col-md-6 pt-3">

                            <label for="address2" class="form-label">อัพโหลดไฟล์ <span class="text-muted">(Optional)</span></label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="fileUpload" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <hr class="my-4">



                        <div class="row gy-3 mt-3 mb-3">
                            <div class="d-flex col-12 justify-content-center">

                                <button class="btn btn-success me-2" name="submit" type="submit">ตกลง</button>
                                <a href="user-home.php" class="btn btn-danger ms-2">ยกเลิก</a>

                            </div>
                        </div>



                    </form>


                </div>
                <div class="card-footer text-muted">

                </div>
            </div>



        </div>



        <!-- จบ Section -->
    </section>






    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="/myqnumber/lib/bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $('.mydatatable').DataTable();
    </script>

    <script type="text/javascript" src="viewmodal.js"></script>


</body>


<!-- FOOTER -->
<footer class="my-5 pt-4 container">
    <p class="float-end"><a class="FBtoT" href="#">Back to top</a></p>
    <p>&copy; 2017–2021 Company, Inc. </p>
</footer>

</html>