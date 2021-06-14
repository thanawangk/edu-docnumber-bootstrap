<?php
require("dbConn.php");
session_start();

$namearr = array('');
$selectuser = "select Name from type";
$reql = $db->query($selectuser);

while ($row = mysqli_fetch_array($reql)) {
    array_push($namearr, $row['Name']);
}

$nameadd = count($namearr);
$_SESSION['nameadd'] = $nameadd;
// if (!$_SESSION['login']) {
//     header("location: /myqnumber/login.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กรอกเอกสาร</title>

    <link rel="stylesheet" href="css/ss3.css">
    <link rel="stylesheet" href="/myqnumber/lib/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&family=Shadows+Into+Light&display=swap" rel="stylesheet">


    <style>
        body {
            /* height: 768px; */
            background: linear-gradient(to right,
                    #164A41, #4D774E, #9DC88D);
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
                            <li><a class="dropdown-item" href="logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?')"><i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ</a></li>
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
                        <li><a href="admin-home.php" class="nav-link px-2 link-secondary">หน้าแรก</a></li>
                        <div class="C_nav1">
                            <li><a href="admin-form.php" class="nav-link px-2 link-dark">กรอกขอเลข</a></li>
                        </div>
                        <li><a href="admin-reform.php" class="nav-link px-2 link-dark">กรอกย้อนหลัง</a></li>
                        <li><a href="admin-booktype.php" class="nav-link px-2 link-dark">ประเภทหนังสือ</a></li>
                        <li><a href="admin-users.php" class="nav-link px-2 link-dark">จัดการสมาชิก</a></li>
                    </ul>
                </div>
            </header>
        </div>

        <!-- เนื้อหา -->
        <div class="container col-lg-8 mb-3 bg-light p-3 pt-4 pb-4">

            <!-- การ์ด -->
            <div class="card ">
                <div class="card-header">
                    <h3>กรอกขอเลขเอกสาร</h3>
                </div>
                <div class="card-body ps-4 pe-4">

                    <!-- ฟอร์ม -->
                    <?php
                    $user_id = $_SESSION['AD_userid'];
                    $date_y = (date("Y") + 543);
                    /*SELECT permission.UserID, permission.TypeUseID,type.current_year FROM permission 
                        INNER JOIN type ON permission.TypeUseID = type.TypeID WHERE type.current_year = 'ปีปัจจุบัน'*/
                    $selecttypeuse = "SELECT permission.UserID, permission.TypeUseID,type.current_year FROM permission INNER JOIN type ON permission.TypeUseID = type.TypeID WHERE type.current_year = '$date_y' AND permission.UserID = '$user_id'";
                    $reqltype = $db->query($selecttypeuse);

                    $listusetype = array('');
                    while ($rowtypeuse = $reqltype->fetch_assoc()) {
                        array_push($listusetype, $rowtypeuse['TypeUseID']);
                    }
                    $countlist = count($listusetype);
                    ?>

                    <form class="needs-validation" action="admin-form-insert.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">

                            <div class="container">

                            </div>


                            <div class="col-md-4">
                                <label for="state" class="form-label">ประเภทหนังสือ</label>
                                <select class="form-select" name="type_id" id="state" required>
                                    <option value="">---------กรุณาเลือกเอกสาร---------</option>
                                    <?php
                                    $loop = 1;
                                    while ($loop < $countlist) {
                                        $selecttype = "select * from type where TypeID = '$listusetype[$loop]'";
                                        $reql = $db->query($selecttype);
                                        $rowtype = $reql->fetch_assoc();
                                        $namebook = $rowtype['Name'];
                                    ?>
                                        <option name="drop<?php echo $loop ?>" value="<?php echo $listusetype[$loop] ?>"><?php print_r($namebook); ?></option>
                                    <?php
                                        $loop += 1;
                                    } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-4 ">
                                <label for="zip" class="form-label">ลงวันที่</label>
                                <?php
                                $date_d = date("d-m"); // วัน เดือน
                                $date_y = (date("Y") + 543); // ปี
                                $date_t = date("H:i:s"); // เวลา
                                echo "<input type='text' class='form-control' id='zip' name='date' value='$date_d-$date_y' required readonly>";
                                ?>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <label for="firstName" class="form-label">ชื่อผู้ส่ง</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="send" id="firstName" placeholder="ชื่อ-นามสกุล" required>
                                    <span class="input-group-text">ถึง</span>
                                    <div class="invalid-feedback">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="lastName" class="form-label">ชื่อผู้รับ</label>
                                <div class="input-group has-validation">

                                    <input type="text" class="form-control" name="to" id="lastName" placeholder="ชื่อ-นามสกุล" required>
                                    <div class="invalid-feedback">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label for="address" class="form-label">เรื่อง</label>
                                <textarea type="text" class="form-control" name="story" id="address" placeholder="" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>






                        </div>


                        <div class="col-md-6 pt-3">

                            <label for="address2" class="form-label">อัพโหลดไฟล์ <span class="text-muted">(Optional)</span></label>
                            <div class="input-group mb-3">
                                <input type="file" name="fileUpload" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <hr class="my-4">



                        <div class="row gy-3 mt-3 mb-3">
                            <div class="d-flex col-12 justify-content-center">

                                <button class="btn btn-success me-2" name="submit" type="submit">ตกลง</button>
                                <a href="admin-home.php" class="btn btn-danger ms-2">ยกเลิก</a>

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




</body>


<!-- FOOTER -->
<footer class="my-5 pt-4 container">
    <p class="float-end"><a class="FBtoT" href="#">Back to top</a></p>
    &copy; 2017–2021 Company, Inc. </>
</footer>

</html>