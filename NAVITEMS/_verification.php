<?php
require_once("INCLUDE/initialize.php");
?>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />

    <style>
    #image-preview {
        width: 100;
        /* Fixed width */
        height: 250px;
        /* Fixed height */
        border: 1px solid #ccc;
        margin: auto;
        overflow: hidden;
        /* To ensure the image does not overflow */
    }

    #image-preview img {
        width: 100%;
        height: 250px;
        object-fit: contain;
    }
    </style>
</head>
<div class="container">
    <form method="post" class="text-center" enctype="multipart/form-data" autocomplete="off">
        <div class="row mt-3">
            <h4><span class="bi-shield-check"></span> <?php echo $title;?></h4>
            <hr>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="text-center mb-2">
                    <div id="image-preview"></div>
                </div>
                <div class="form-floating mb-2 text-start">
                    <strong>Upload your ID:</strong>

                    <input type="file" id="image-input" name="image" accept="image/*" onchange="previewImage()"
                        required />

                </div>
                <div class="form-floating mb-2 text-start">
                    <input type="text" class="form-control" name="VerCode" id="floatingInput"
                        placeholder="Verification Code" required>
                    <label for="floatingInput">Verification Code</label>
                </div>
            </div>

            <div class="col-md-4">
            </div>

        </div>
        <div class="row g-1 mb-1">
            <div class="col-12">
                <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
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
</script>
<?php

if (isset($_POST['btnSubmit'])) {



 $file_name = $_FILES['image']['name'];
 $file_tmp =$_FILES['image']['tmp_name'];
 move_uploaded_file($file_tmp,"IMG/".$file_name);


  $VerCode = trim($_POST['VerCode']);

  $sql = "SELECT * FROM `user_account` WHERE 1=1 and VerCode ='$VerCode'";
  $mydb->setQuery($sql);
  $row = $mydb->executeQuery();
  $maxrow = $mydb->num_rows($row);

  $sql = "SELECT REPLACE(Firstname,'-','') as Firstname,REPLACE(Lastname,'-','') as Lastname,REPLACE(REPLACE(REPLACE(Address, '\r', ''), '\n', ''),'-','') as Address1 from user_account WHERE 1=1 and VerCode ='$VerCode'";
  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();
  foreach ($cur as $result) {
  $LNAME=$result->Lastname;
  $FNAME=$result->Firstname;
  $ADD=$result->Address1;
  }



  if ($maxrow > 0) {
    $file_name = $_FILES['image']['name'];
    $file_tmp =$_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp,"IMG/".$file_name);
    shell_exec('"C:\\Program Files\\Tesseract-OCR\\tesseract" "C:\\xampp\\htdocs\\Appointmate\\IMG\\'.$file_name.'" out');

    $myfile = fopen("out.txt", "r") or die("Unable to open file!");
    $laman = fread($myfile,filesize("out.txt"));
    $rlaman=str_replace("-","",$laman);
    $flaman= preg_replace('/[^A-Za-z0-9. -]/', '', $rlaman);
   // echo $flaman;

    fclose($myfile);

    $sql = "UPDATE user_account SET Laman='$flaman' WHERE VerCode ='$VerCode'";

    $mydb->setQuery($sql);
    $mydb->executeQuery();


  $sql = "SELECT 1 as FVAL from user_account WHERE 1=1 and Laman like '%$FNAME%' AND VerCode ='$VerCode'";

  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();
  foreach ($cur as $result) {
  $FNAMEVAL=$result->FVAL;
  }

  $sql = "SELECT 1 as LVAL from user_account WHERE 1=1 and Laman like '%$LNAME%' AND VerCode ='$VerCode'";
  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();
  foreach ($cur as $result) {
  $LNAMEVAL=$result->LVAL;
  }

//   $sql = "SELECT 1 as ADDVAL from user_account WHERE 1=1 and REPLACE(REPLACE(Laman, '\r', ''), '\n', '') like '%$ADD%'";
//   $mydb->setQuery($sql);
//   $cur = $mydb->loadResultList();
//   foreach ($cur as $result) {
//   $ADDVAL=$result->ADDVAL;
//   }

  if($FNAMEVAL==1)
  {
    if($LNAMEVAL==1)
    {


            $sql = "UPDATE user_account SET IsVerified='1',`Filename`='$file_name' WHERE VerCode ='$VerCode'";
            $mydb->setQuery($sql);
            $mydb->executeQuery();

            $sql = "UPDATE user_account SET VerCode='' WHERE VerCode ='$VerCode'";
            $mydb->setQuery($sql);
            $mydb->executeQuery();
            echo '<script type="text/javascript">
            swal({
                title: "Account Verified",
                text: "Your account has been successfully verified, you need to re login.",
                type: "success",
                showConfirmButton: true
            },  function () {
                window.location.href = "logout.php";
            });
         </script>';

    } else
    {
    echo '<script type="text/javascript">
            swal({
                title:"Lastname not clear!",
                text: "Please upload clear photo of your ID!",
                type: "error",
                showConfirmButton: true
            });
            </script>';
    }

  }else
    {
    echo '<script type="text/javascript">
            swal({
                title:"Firstname not clear!",
                text: "Please upload clear photo of your ID!",
                type: "error",
                showConfirmButton: true
            });
            </script>';
    }




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