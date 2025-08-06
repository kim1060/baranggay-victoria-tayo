<?php
require_once("INCLUDE/initialize.php");
$_SESSION['attempt']=0;

// login confirmation
if (isset($_SESSION['UserID'])) {
  redirect(web_root . "index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="IMG/baranggay-victoria.png">
    <!-- Font Awesome -->
    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
    <!--SWEET ALERT -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <style>
    body {
        /* background-image: url("img/DILG_LOGO.png"); */
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: 55% 100vh;
        position: relative;
        opacity: 97%;
    }



    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
        body {
            background-image: none;
        }
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {}

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {}

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {}
    </style>
</head>

<body>
    <!-- Section: Design Block -->
    <section class="vh-100" style="background-color:#16445e;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-12 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post" autocomplete="off">
                                        <!-- <div class="align-items-center mb-3 pb-1 text-center">
                                            <img src="img/DMW_LOGO.png" alt="login form" class="img-fluid"
                                                style="border-radius: 25px; width:40%;" />
                                        </div> -->
                                        <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">New
                                            Password</h5>
                                        <div class="form-outline mb-2">
                                            <input type="text" id="VerCode" name="VerCode"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example17">Verification Code</label>
                                        </div>
                                        <div class="form-outline mb-2">
                                            <input type="text" id="Password" name="Password"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example17">Enter New Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-success btn-lg btn-block" type="submit"
                                                name="btnLogin" id="btnLogin">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js"
        integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>

    <script>
    function ShowPass() {
        var x = document.getElementById("pword");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    </script>
</body>

</html>

<?php

if (isset($_POST['btnLogin'])) {
  $VerCode = trim($_POST['VerCode']);
  $Password = sha1($_POST['Password']);
  $sql = "SELECT * FROM `user_account` WHERE 1=1 and VerCode ='$VerCode'";
  $mydb->setQuery($sql);
  $row = $mydb->executeQuery();
  $maxrow = $mydb->num_rows($row);

  if ($maxrow > 0) {
    $sql = "UPDATE user_account SET Password= '$Password' WHERE VerCode ='$VerCode'";
    $mydb->setQuery($sql);
    $mydb->executeQuery();

    $sql = "UPDATE user_account SET VerCode= '' WHERE VerCode ='$VerCode'";
    $mydb->setQuery($sql);
    $mydb->executeQuery();
    echo '<script type="text/javascript">
    swal({
        title: "Password Changed!",
        text: "Your password has been successfully changed, you may login now.",
        type: "success",
        showConfirmButton: true
    },  function () {
        window.location.href = "login.php";
    });
    </script>';
  }
  else{
    echo '<script type="text/javascript">
    swal({
        title:"Invalid Code!",
        text: "Please check your email for valid verification code!",
        type: "warning",
        showConfirmButton: true
    });
    </script>';

  }
}

?>