<?php
require_once("include/initialize.php");
$_SESSION['attempt']=0;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
    <title>Registration</title>
    <link rel="icon" type="image/x-icon" href="img/APP_LOGO.PNG">
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

    #image-preview {
        width: 450px;
        /* Fixed width */
        height: 250px;
        /* Fixed height */
        border: 1px solid #ccc;
        margin: auto;
        overflow: hidden;
        /* To ensure the image does not overflow */
    }

    #image-preview img {
        width: 450px;
        height: 250px;
        object-fit: contain;
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
    <section class="vh-100" style=" background-color:#16445e;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-8">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                                        <!-- <div class="align-items-center mb-3 pb-1 text-center">
                                            <img src="img/DMW_LOGO.png" alt="login form" class="img-fluid"
                                                style="border-radius: 25px; width:20%;" />
                                        </div> -->
                                        <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">Account
                                            Registration</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Lastname" name="Lastname"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example17">Last Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Firstname" name="Firstname"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example17">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Middlename" name="Middlename"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="form2Example17">Middle Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Address" name="Address"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example17">Address</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-outline mb-2">
                                                            <input type="text" id="Age" name="Age"
                                                                class="form-control form-control-lg" required />
                                                            <label class="form-label" for="form2Example17">Age</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <select name="Status" id="Status"
                                                            class="form-select form-control-lg mb-2" required>
                                                            <option value="">Select Status</option>
                                                            <?php
                                                                $sql = "SELECT * FROM `civilstatus`";
                                                                $mydb->setQuery($sql);
                                                                $cur = $mydb->loadResultList();
                                                                foreach ($cur as $res) {
                                                                    # code...
                                                                    echo '<option value='.$res->CivilStatus.'>'.$res->CivilStatus.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-outline mb-2">
                                                            <input type="text" id="Citizenship" name="Citizenship"
                                                                class="form-control form-control-lg" required />
                                                            <label class="form-label"
                                                                for="form2Example17">Citizenship</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-outline mb-2">
                                                    <input type="email" id="Email" name="Email"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example17">Email</label>
                                                </div>
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Mobile" name="Mobile"
                                                        class="form-control form-control-lg" maxlength="11"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                    <label class="form-label" for="form2Example17">Mobile #</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="text" id="Username" name="Username"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example17">User Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="password" id="Password" name="Password"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example27">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-outline mb-2">
                                                    <input type="password" id="ConfirmPassword" name="ConfirmPassword"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="form2Example27">Re-enter
                                                        Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="checkbox" onclick="ShowPass()" class="align-start">
                                            Show
                                            Password
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="pt-1 mb-4">
                                                    <button class="btn btn-success btn-lg btn-block" type="submit"
                                                        name="btnRegister" id="btnRegister">NEXT</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>




                                        <a class="fw-bold text-success" href="login.php">Log in here!</a>
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
        var x = document.getElementById("Password");
        var y = document.getElementById("ConfirmPassword");
        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
        } else {
            x.type = "password";
            y.type = "password";
        }
    }

    function previewImage() {
        var fileInput = document.getElementById("image-input");
        var imagePreview = document.getElementById("image-preview");

        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.innerHTML =
                    '<img src="' + e.target.result + '" alt="Preview">';
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    // Function to capitalize input values
    function capitalizeInput(event) {
        event.target.value = event.target.value.toUpperCase();
    }

    // Attach the capitalizeInput function to relevant input fields
    document.getElementById('Lastname').addEventListener('input', capitalizeInput);
    document.getElementById('Firstname').addEventListener('input', capitalizeInput);
    document.getElementById('Middlename').addEventListener('input', capitalizeInput);
    document.getElementById('Address').addEventListener('input', capitalizeInput);
    document.getElementById('Citizenship').addEventListener('input', capitalizeInput);
    </script>
</body>

</html>

<?php



  if (isset($_POST['btnRegister'])) {
    $Mobile = $_POST['Mobile'];
    $Email = $_POST['Email'];
    $Lastname         = $_POST['Lastname'];
    $Firstname         = $_POST['Firstname'];
    $Address         = $_POST['Address'];

    // $file_name = $_FILES['image']['name'];
    // $file_tmp =$_FILES['image']['tmp_name'];
    // move_uploaded_file($file_tmp,"IMG/".$file_name);
    // //echo '<img src="IMG/'.$file_name.'" style="width:100%">';
    // shell_exec('"C:\\Program Files\\Tesseract-OCR\\tesseract" "C:\\xampp\\htdocs\\Appointmate\\IMG\\'.$file_name.'" out');

    // $myfile = fopen("out.txt", "r") or die("Unable to open file!");
    // $laman = fread($myfile,filesize("out.txt"));

    // echo fread($myfile,filesize("out.txt"));



  //echo str_replace(" ","",$Address);
//   $finaladd=str_replace(" ","",$Address);
//  $f=str_replace(",","",$finaladd);
//  echo str_replace(".","",$f);

//   $finallaman=str_replace(" ","",$laman);
//  $l=str_replace(",","",$finallaman);

//  $ff=str_replace(".","",$f);
// $ll=str_replace(".","",$l);

// if (str_contains($ll, $ff)) {
//     echo "Substring found!";
// } else {
//     echo "Substring not found.";
// }

//     echo " <input type='text' value='$ll'>";

//     fclose($myfile);


    if ($_POST['Password'] !== $_POST['ConfirmPassword']) {
      echo '
      <script type="text/javascript">
       swal({
          title: "Password not match!",
          text: "Please check your Password.",
          type: "warning",
          showConfirmButton: false,
          timer: 2500
      });
      </script>
      ';
    }

    else {


            $Users = New UserAccount();
            $Users->Lastname         = $_POST['Lastname'];
            $Users->Firstname         = $_POST['Firstname'];
            $Users->Middlename         = $_POST['Middlename'];
            $Users->Address         = $_POST['Address'];
            $Users->Age         = $_POST['Age'];
            $Users->Status         = $_POST['Status'];
            $Users->Citizenship         = $_POST['Citizenship'];
            $Users->Email         = $_POST['Email'];
            $Users->Contact         = $_POST['Mobile'];
            $Users->Username         = $_POST['Username'];
            $Users->Password      = sha1($_POST['Password']);
            $Users->Laman      = $_POST['Laman'];
            $Users->UserType      = "USER";
            $Users->VerCode      = "";
            $Users->IsVerified      = "0";
            $Users->create();


            echo '
            <script type="text/javascript">
             swal({
                title: "Account Created!",
                text: "Will send you an Email for verification code. Please login and verify your account.",
                type: "success",
              showConfirmButton: true
          },  function () {
              window.location.href = "login.php";
          });
          </script>';

           $Code = rand(123654,987456);

           $sql = "SELECT MAX(UserID) as lastid from user_account";
           $mydb->setQuery($sql);
           $cur = $mydb->loadResultList();
           foreach ($cur as $result) {
           $lastid=$result->lastid;
           }

          $sql = "UPDATE user_account SET VerCode='$Code' WHERE UserID='$lastid'";
          $mydb->setQuery($sql);
          $mydb->executeQuery();





              // $ch = curl_init();
              // $parameters = array(
              //         'apikey' => '06f202f323dc165c1809c5310e339a17',
              //         'number' =>  $Mobile,
              //         'message' => 'DMW: Good day '.$Firstname.' '.$Lastname.' ! Your registration verification code is '.$Code.'. Thank you!',
              //         'sendername' => 'SEMAPHORE'
              //         );
              //         curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
              //         curl_setopt( $ch, CURLOPT_POST, 1 );
              //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
              //         curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
              //         $result = curl_exec($ch);
              //         curl_close($ch);

          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';
          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'thesiswebsite2024@gmail.com';
          $mail->Password = 'ylku vutf rqsi jzfy';
          $mail->SMTPSecured = 'tls';
          $mail->Port = 587;
          $mail->setFrom('thesiswebsite2024@gmail.com');
          $mail->addAddress($Email);
          $mail->isHTML(true);
          $mail->Subject='SYSTEM NOTIFICATION: VERIFICATION CODE';
          $mail->Body='<HTML>Good day '.$Firstname.' '.$Lastname.' ! Your registration verification code is <strong>'.$Code.'</strong>. Login got to My Account and verify. Thank you!</HTML>';
          $mail->send();
        }

    }


  ?>