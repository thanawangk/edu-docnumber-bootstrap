<?php
require("dbConn.php");
session_start();

if (!$_SESSION['login']) {
    header("location: /myqnumber/login.php");
    exit;
}
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

    <link rel="shortcut icon" type="image/x-icon" href="img/ku-logo1.png" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&family=Shadows+Into+Light&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right,
                    #164A41, #4D774E, #9DC88D);
            font-family: 'Sarabun', sans-serif;
        }

        .mydatatable tbody tr td {
            /* max-width: 150px; */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                    <span class="text-success fw-bold">KU </span><span class="fw-bold" style="color:OliveDrab;">SRC</span>
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
        <div class="container col-lg-9 p-3">
            <div class="ku-header p-1 pb-md-4 mx-auto text-center">
                <div class="display-5 fw-normal text-white">ระบบออกเลขหนังสือราชการ</div>
            </div>
        </div>

        <!-- แถบเมนู -->
        <div class="container col-lg-9 alert-secondary">
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
        <div class="container col-lg-9 mb-3 bg-light p-3">

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
                                    $textlimit = iconv_substr($rowdoc["Text"], 0, 10);
                                    echo '  <td><p class=\'text-danger\'><del>อว.6503' . $typenum . '/' . $rowdoc["resultNumber"] . '</del></td>';

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Sent_Name"]}</del>
                                            </td>";

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowdoc["Receive_Name"]}</del>
                                            </td>";


                                    echo "  <td>
                                                <p class='text-danger'><del> $textlimit </del>
                                            </td>";


                                    echo "  <td>
                                                <p class='text-danger'>ยกเลิก</p>
                                            </td>";

                                    echo "  <td>
                                                <a href='#' title='ดูรายละเอียด' class='btn btn-outline-info waves-effect view-detail'data-id='{$rowdoc["Date"]}' data-num='อว.6503$typenum/{$rowdoc["resultNumber"]} ' data-sentname=' {$rowdoc["Sent_Name"]}' data-resvname='{$rowdoc["Receive_Name"]}' data-text='{$rowdoc["Text"]}' data-status='{$rowdoc["Status"]}'><i class='fas fa-search'></i></a>

                                                <a title='ใช้งานเอกสาร' class='btn btn-outline-success waves-effect activate-doc ' href='admin-doc-activate.php?docid={$rowdoc["DocumentID"]}' onclick=\"return confirm('คุณต้องการใช้งานเอกสารใช่หรือไม่?')\"><i class='fas fa-check'></i></a>
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
                                            $filename = $rowdoc["Filee"];
                                            $docids = $rowdoc["DocumentID"];
                                            $selectnumbook = "select document.TypeID,type.TypeID,type.TypeNumber from type JOIN document ON type.TypeID = document.TypeID WHERE document.DocumentID = '$docids'";
                                            $reql2 = $db->query($selectnumbook);
                                            $row2 = mysqli_fetch_array($reql2);
                                            $typenum = $row2['TypeNumber'];
                                            $textlimit = iconv_substr($rowdoc["Text"], 0, 10);
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
                                            <?php echo $textlimit; ?>
                                        </td>

                                        <td>
                                            <?php if ($rowdoc["Status"] == 1) {
                                                echo "<p class='text-success fw-bolder'>ใช้งาน</p>";
                                            } elseif ($rowdoc["Status"] == 2) {
                                                echo "<p class='text-muted fw-bolder'>จอง</p>";
                                            } elseif ($rowdoc["Status"] == 3) {
                                                echo "<p class='text-primary fw-bolder'>กรอกย้อนหลัง</p>";
                                            }
                                            ?>

                                        </td>

                                        <!-- ปุ่ม -->
                                        <td>
                                            <?php if ($rowdoc["Status"] == 2) {
                                                echo " ";
                                            } else {
                                            ?>
                                                <div class="btn-group" role="group" aria-label="Second group">

                                                    <!-- ปุ่ม view -->
                                                    <a href="#" title='ดูรายละเอียด' class="btn btn-info waves-effect view-detail" data-fname="<?php echo $filename; ?>" data-id="<?php echo $rowdoc["Date"]; ?>" data-num="<?php echo 'อว.6503' . $typenum . '/' . $rowdoc["resultNumber"]; ?>" data-sentname="<?php echo $rowdoc["Sent_Name"]; ?>" data-resvname="<?php echo $rowdoc["Receive_Name"]; ?>" data-text="<?php echo $rowdoc["Text"]; ?>" data-status="<?php echo $rowdoc["Status"]; ?>"><i class="fas fa-search"></i>
                                                    </a>

                                                    <!-- ปุ่ม file -->
                                                    <?php
                                                    if ($filename == null) {

                                                        echo "<a title='ไม่มีไฟล์ PDF' href='uploads/readpdf.php?filename={$filename}' class='btn btn-success disabled ps-3 pe-3' ms-2 ><i class='fas fa-file-pdf'></i></a>";
                                                    } else {
                                                        echo "<a title='แสดงไฟล์ PDF' href='uploads/readpdf.php?filename={$filename}' class='btn btn-success ps-3 pe-3' ms-2 ><i class='fas fa-file-pdf'></i></a>";
                                                    }
                                                    ?>

                                                    <!-- ปุ่ม edit,cancel -->
                                                    <a title='แก้ไขเอกสาร' class='btn btn-secondary waves-effect edit-doc' href='admin-editdoc.php?docid=<?php echo $rowdoc["DocumentID"]; ?>'><i class="far fa-edit"></i></a>
                                                </div>

                                                <a title='ยกเลิกเอกสาร' class='btn btn-danger waves-effect ms-1 ps-3 pe-3 cancel-doc ' href='admin-doc-cancel.php?docid=<?php echo $rowdoc["DocumentID"]; ?>' onclick="return confirm('คุณต้องการยกเลิกเอกสารนี้ใช่หรือไม่?')"><i class="fas fa-times"></i></a>



                                        </td>
                                    </tr>
                        <?php }
                                        }
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
                <div class="modal-header" style="background-color:#4D774E;">
                    <h3 class="modal-title text-white">รายละเอียด</h3>
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
                    <br>

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
        $('.mydatatable').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    </script>
    <script type="text/javascript" src="viewmodal.js"></script>

</body>

<!-- FOOTER -->
<footer class="my-5 pt-4 container">
    <p class="float-end"><a class="FBtoT" href="#">Back to top</a></p>
    <p>&copy; 2017–2021 Company, Inc. </p>
</footer>

</html>