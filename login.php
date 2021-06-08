<?php
include('config.php');

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
                        <img class="img-fluid" src="img/ku-sublogo.png" alt="" width="200" height="50">


                        <div class="h4 text-gray-900 mb-4 ">ระบบออกเลขหนังสือราชการ</div>
                        <p class="h6 text-gray-600 mb-4">โปรดเข้าสู่ระบบด้วยแอคเคาท์ @eng.ku.th เท่านั้น</p>

                        <?php
                        if ($login_button == '') {
                            header('location:home.php');
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

    <p class="mt-5 mb-3 text-muted">&copy; 2021–2077</p>



    <!-- ปุ่ม Google
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script> -->

    <script src="/myqnumber/lib/bootstrap-5.0.1-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>