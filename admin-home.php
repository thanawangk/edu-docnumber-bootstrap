<?php
require("dbConn.php");
session_start();

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
    <title>หน้าแรก</title>

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


        /* body {
            background-color: #08e1ae;
            background-image: linear-gradient(315deg, #08e1ae 0%, #98de5b 74%);
        } */
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
                        <div class="C_nav1">
                            <li><a href="#" class="nav-link px-2 link-secondary">หน้าแรก</a></li>
                        </div>
                        <li><a href="admin-form.php" class="nav-link px-2 link-dark">กรอกขอเลข</a></li>
                        <li><a href="admin-reform.php" class="nav-link px-2 link-dark">กรอกย้อนหลัง</a></li>
                        <li><a href="admin-booktype.php" class="nav-link px-2 link-dark">ประเภทหนังสือ</a></li>
                        <li><a href="admin-users.php" class="nav-link px-2 link-dark">จัดการสมาชิก</a></li>
                    </ul>
                </div>
            </header>
        </div>

        <!-- เนื้อหา -->
        <div class="container col-lg-8 mb-3 bg-light p-3">

            <!-- ตาราง -->
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mydatatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>วันที่</th>
                                <th>เลขเอกสาร</th>
                                <th>ผู้ส่ง</th>
                                <th>ผู้รับ</th>
                                <th>เรื่อง</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- ดึงข้อมูลจากDB document * -->
                            <?php
                            $selectdoc = "select * from document ";
                            $reql = $db->query($selectdoc);
                            while ($rowdoc = $reql->fetch_assoc()) {

                                if ($rowdoc["Status"] == 0) {

                                    echo "<tr>
                                            <td>
                                                <p class='text-danger'><del>{$rowdoc["DocumentID"]}</del>
                                            </td>";
                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Date"]}</del>
                                            </td>";

                                    $docids = $rowdoc["DocumentID"];
                                    $selectnumbook = "select document.TypeID,type.TypeID,type.TypeNumber from type JOIN document ON type.TypeID = document.TypeID WHERE document.DocumentID = '$docids'";
                                    $reql2 = $db->query($selectnumbook);
                                    $row2 = mysqli_fetch_array($reql2);
                                    $typenum = $row2['TypeNumber'];
                                    echo '  <td><p class=\'text-danger\'><del>อว.6503' . $typenum . '/' . $rowdoc["resultNumber"] . '</del></td>';

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Sent_Name"]}</del>
                                            </td>";

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Receive_Name"]}</del>
                                            </td>";


                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Text"]}</del>
                                            </td>";


                                    echo "  <td>
                                                <p class='text-danger'>ยกเลิก</p>
                                            </td>";

                                    echo "  <td>
                                                <a href='#' class='btn btn-outline-info waves-effect view-detail' data-id='{$rowdoc["Date"]}'  data-num='อว.6503$typenum/{$rowdoc["resultNumber"]} ' data-sentname=' {$rowdoc["Sent_Name"]}' data-resvname='{$rowdoc["Receive_Name"]}' data-text='{$rowdoc["Text"]}' data-status='{$rowdoc["Status"]}'><i class='fas fa-search'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                } else {
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo $rowdoc["DocumentID"]; ?>
                                        </td>

                                        <td>
                                            <?php echo $rowdoc["Date"]; ?>
                                        </td>

                                        <td>
                                            <!-- เลขเอกสาร +ต่อกัน -->
                                            <?php
                                            $docids = $rowdoc["DocumentID"];
                                            $selectnumbook = "select document.TypeID,type.TypeID,type.TypeNumber from type JOIN document ON type.TypeID = document.TypeID WHERE document.DocumentID = '$docids'";
                                            $reql2 = $db->query($selectnumbook);
                                            $row2 = mysqli_fetch_array($reql2);
                                            $typenum = $row2['TypeNumber'];
                                            echo 'อว.6503' . $typenum . '/' . $rowdoc["resultNumber"];
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo $rowdoc["Sent_Name"]; ?>
                                        </td>

                                        <td>
                                            <?php echo $rowdoc["Receive_Name"]; ?>
                                        </td>

                                        <td>
                                            <?php echo $rowdoc["Text"]; ?>
                                        </td>

                                        <td>
                                            <?php echo "<p class='text-success'>ใช้งาน</p>"; ?>
                                        </td>

                                        <!-- ปุ่ม -->
                                        <td>
                                            <div class="btn-group me-2" role="group" aria-label="Second group">
                                                <!-- ปุ่ม view -->
                                                <a href="#" class="btn btn-info waves-effect view-detail" data-id="<?php echo $rowdoc["Date"]; ?>" data-num="<?php echo 'อว.6503' . $typenum . '/' . $rowdoc["resultNumber"]; ?>" data-sentname="<?php echo $rowdoc["Sent_Name"]; ?>" data-resvname="<?php echo $rowdoc["Receive_Name"]; ?>" data-text="<?php echo $rowdoc["Text"]; ?>" data-status="<?php echo $rowdoc["Status"]; ?>"><i class="fas fa-search"></i>
                                                </a>
                                                <!-- ปุ่ม edit,cancel -->
                                                <?php
                                                if ($rowdoc["Status"] == 1) {
                                                    echo "<a class='btn btn-secondary waves-effect edit-doc' href='admin-edit-doc.php?docid= {$rowdoc["DocumentID"]}'><i class=\"far fa-edit\"></i></a>";

                                                    echo "<a class='btn btn-danger waves-effect cancel-doc ' href='admin-cancel-doc.php?docid= {$rowdoc["DocumentID"]}' onclick=\"return confirm('คุณต้องการยกเลิกเอกสารนี้ใช่หรือไม่?')\"><i class=\"fas fa-times\"></i></a>";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>วันที่</th>
                                <th>เลขเอกสาร</th>
                                <th>ชื่อผู้รับ</th>
                                <th>ชื่อผู้ส่ง</th>
                                <th>เรื่อง</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>




        <!-- จบ Section -->
    </section>



    <!-- ส่วน Modal -->
    <div class="modal fade" id="view-detailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title ">รายละเอียด</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-center">
                        <label for="status">
                            <h4>สถานะ :</h4>
                        </label>
                        &nbsp;<span class="h4" id="status"></span><br>
                    </div>

                    <div class="col-6">
                        <label for="num">
                            <h5>เลขเอกสาร</h5>
                        </label>
                        <input type="text" name="num" id="num" readonly><br>
                        <label for="num">ลงวันที่</label>
                        <input type="text" name="id" id="id" readonly><br>
                    </div>

                    <div class="col-lg-12">
                        <label for="sentname">ชื่อผู้ส่ง</label>
                        <input type="text" name="sentname" id="sentname" readonly><br>

                        <label for="resvname">ชื่อผู้รับ</label>
                        <input type="text" name="resvname" id="resvname" readonly><br>
                    </div>


                    <div class="form-outline">
                        <label for="text">เรื่อง</label>
                        <textarea type="text" class="form-control" name="text" id="text" rows="3" readonly></textarea>
                    </div>

                    <div class="col-md-8 pt-3">

                        <label for="address2" class="form-label">ไฟล์ <span class="text-muted">(Optional)</span></label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <!-- สคริป -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="/myqnumber/lib/bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $('.mydatatable').DataTable();
    </script>
    <script type="text/javascript" src="viewmodal1.js"></script>

</body>

<!-- FOOTER -->
<footer class="my-5 pt-4 container">
    <p class="float-end"><a class="FBtoT" href="#">Back to top</a></p>
    <p>&copy; 2017–2021 Company, Inc. </p>
</footer>

</html>