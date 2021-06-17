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
    <title>ประเภทหนังสือ</title>

    <link rel="stylesheet" href="css/ss3.css">
    <link rel="stylesheet" href="/myqnumber/lib/bootstrap-5.0.1-dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            /* height: 768px; */
            background: linear-gradient(to right,
                    #164A41, #4D774E, #9DC88D);
            font-family: 'Sarabun', sans-serif;
        }
        .mydatatable tbody tr td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

</head>

<body>
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
        <div class="container col-lg-8 p-3 border border-white border-3 "  >
            <div class="ku-header p-1 pb-md-4 mx-auto text-center">
                    <div class="display-5 fw-normal text-white">ระบบออกเลขหนังสือราชการ</div>
            </div>
        </div>

        <!-- แถบเมนู -->
        <div class="container col-lg-8 alert-secondary">
            <header class="p-3 mb-1 mt-1 border-bottom alert-secondary">
                <div class="container">
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="admin-home.php" class="nav-link px-2 link-secondary">หน้าแรก</a></li>
                        <li><a href="admin-form.php" class="nav-link px-2 link-dark">กรอกขอเลข</a></li>
                        <li><a href="admin-reform.php" class="nav-link px-2 link-dark">กรอกย้อนหลัง</a></li>

                        <div class="C_nav3">
                            <li><a href="admin-booktype.php" class="nav-link px-2 link-dark">ประเภทหนังสือ</a></li>
                        </div>

                        <li><a href="admin-users.php" class="nav-link px-2 link-dark">จัดการสมาชิก</a></li>
                    </ul>
                </div>
            </header>
        </div>


        <div class="container col-lg-8 mb-3 bg-light p-3">

            <div class="mb-3 d-flex justify-content-end">
                <a class="add_booktype_user p-2" href="admin-addbook.php" role="button">เพิ่มประเภท</a>
            </div>

            <!-- ตาราง -->
            <div class="col ">
                <div class="table-responsive ">
                    <table class="table table-bordered table-striped mydatatable pt-3 pb-3">
                        <thead>
                            <tr>
                                <th>เลขประเภท</th>
                                <th>ชื่อ</th>
                                <th>เลขปัจจุบัน</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $selectbook = "select * from type ";
                            $reql = $db->query($selectbook);
                            while ($rowbook = $reql->fetch_assoc()) {
                            ?>

                                <?php
                                if ($rowbook["Status"] == 0) {

                                    echo "<tr>
                                            <td>
                                                <p class='text-danger'><del>{$rowbook["TypeNumber"]}</del>
                                            </td>";

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowbook["Name"]}</del>
                                            </td>";

                                    echo "  <td>
                                                <p class='text-danger'><del>{$rowbook["current_number"]}</del>
                                            </td>";

                                    echo "  <td>
                                                <p class='text-danger'>ไม่ใช้แล้ว</p>
                                            </td>";

                                    echo "<td>
                                            <a title='ใช้งานประเภทหนังสือ' class='btn btn-outline-success waves-effect activate-doc ' href='activate-book-update.php?typeid={$rowbook["TypeID"]}' onclick=\"return confirm('คุณต้องการใช้งานประเภทเอกสารใช่หรือไม่?')\"><i class='fas fa-check'></i></a>
                                            </td>
                                            </tr>";
                                } else {
                                ?>
                                    <tr>
                                        <td><?php echo $rowbook["TypeNumber"]; ?></td>
                                        <td><?php echo $rowbook["Name"]; ?></td>
                                        <td><?php echo $rowbook["current_number"]; ?></td>
                                        <td><?php echo "<p class='text-success'>ใช้งาน</p>"; ?></td>
                                        <td>
                                            <a title='แก้ไขประเภทหนังสือ' class='btn btn-secondary waves-effect edit-book' href='admin-editbook.php?typeid=<?php echo $rowbook["TypeID"]; ?>'><i class="fas fa-edit"></i></a>

                                            <a title='ยกเลิกการใช้งาน' class='btn btn-danger waves-effect ps-3 pe-3 cancel-book ' href='cancel-book-update.php?typeid= <?php echo $rowbook["TypeID"]; ?>' onclick="return confirm('คุณต้องการยกเลิกการใช้งานประเภทหนังสือนี้ใช่หรือไม่?')"><i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>


                        </tbody>

                        <tfoot>
                            <tr>
                                <th>เลขประเภท</th>
                                <th>ชื่อ</th>
                                <th>เลขปัจจุบัน</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>


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