<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
?>
<div class="container" data-aos="zoom-out-up">
    <div class="row mt-3">
        <h4 class="text-center"><span class="bi-journal-check"></span> <?php echo $title;?></h4>
    </div>
    <hr>
    <form method="post" class="text-center" enctype="multipart/form-data">
        <div class="row mt-3">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div class="form-floating mb-2 text-start">
                    <strong>
                        <p>1. Original passport for renewal.</p>
                    </strong>
                    <input type="file" name="file1" id="file1" required>
                </div>
                <div class="form-floating mb-2 text-start">
                    <strong>
                        <p>2. Photocopy of passport (data page only).
                        </p>
                    </strong>
                    <input type="file" name="file2" id="file2" required>
                </div>
                <div class="form-floating mb-2 text-start">
                    <strong>
                        <p>3. Duly accomplished passport application form that can be downloaded from the website.</p>
                    </strong>

                    <input type="file" name="file3" id="file3" required>
                </div>


                <div class="form-floating mb-2">
                    <textarea class="form-control" placeholder="Leave a comment here" name="Remarks"
                        id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
            </div>
            <div class="col-md-2">

            </div>


        </div>
        <div class="row g-1 mb-1">
            <div class="col-12">
                <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Submit</button>
                <a href="index.php?view=services"><button type="button" class="btn btn-outline-danger btn-sm"><span
                            class="bi-x-circle-fill"></span> Cancel</button></a>
            </div>
        </div>
    </form>
</div>

<?php

function file1(){
    $target_dir = "FILE_RENEWALOFPASSPORT/";
    $target_file = $target_dir  . basename($_FILES["file1"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file1"]["name"]);
        }else{
            exit;
        }
} 
function file2(){
    $target_dir = "FILE_RENEWALOFPASSPORT/";
    $target_file = $target_dir  . basename($_FILES["file2"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file2"]["name"]);
        }else{
            exit;
        }
}
function file3(){
    $target_dir = "FILE_RENEWALOFPASSPORT/";
    $target_file = $target_dir  . basename($_FILES["file3"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file3"]["name"]);
        }else{
            exit;
        }
}


if(isset($_POST["btnSubmit"]))
{
    $date = date('Y-m-d H:i:s');
    $MyClass = new _renewalofpassport();
    $MyClass->UserID         = $_SESSION['UserID'];
    $MyClass->File1      = file1();
    $MyClass->File2      = file2();
    $MyClass->File3     = file3();
    $MyClass->Comment         = $_POST['Remarks'];
    $MyClass->Status         = 'PENDING';
    $MyClass->Date         = $date ;
    $MyClass->create();

   

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thesiswebsite2024@gmail.com';
    $mail->Password = 'ylku vutf rqsi jzfy';
    $mail->SMTPSecured = 'ssl';
    $mail->Port = 587;
    $mail->setFrom('thesiswebsite2024@gmail.com');
    $mail->addAddress($_SESSION['Email']);
    $mail->isHTML(true);
    $mail->Subject='SYSTEM NOTIFICATION: RENEWAL OF PASSPORT';
    $mail->Body='<HTML>Good Day! We are now currently validating your transaction. Please wait on our confirmation before you can set an appointment. We will notify you via Email . Thank you!</HTML>';
    $mail->send();

    echo '<script type="text/javascript">
    swal({
        title: "Submitted!",
        text: "We will now validate your transaction request before you can proceed to create a scheduled appointment.\r\n\r\nWe will contact you within the day if your transaction request is possible or not.\r\n\r\nYou may call or email us if we did not respond within the day.\r\n\r\nThank you so much and have a blessed day!",
        type: "success",
        showConfirmButton: true
    },  function () {
        window.location.href = "index.php?view=home";
    });
    </script>';
}

?>