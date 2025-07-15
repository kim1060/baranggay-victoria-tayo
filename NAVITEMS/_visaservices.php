<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
?>
<div class="container" data-aos="zoom-out-up">
    <div class="row mt-3">
        <h4 class="text-center"><span class="bi-shield-check"></span> <?php echo $title;?></h4>
    </div>
    <hr>
    <form method="post" class="text-center" enctype="multipart/form-data">
        <div class="row mt-3">
            <div class="col-md-1">

            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>1. Accomplished application for Non-Immigrant Visa Form.</p>
                            </strong>
                            <input type="file" name="file1" id="file1" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>2. Original and photocopy six (6) months beyond the applicant's stay in the
                                    Philippines.
                                </p>
                            </strong>
                            <input type="file" name="file2" id="file2" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>3. One (1) colored photograph (2 x 2) with plain background.</p>
                            </strong>

                            <input type="file" name="file3" id="file3" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>4. Certificate of Employment.</p>
                            </strong>
                            <input type="file" name="file4" id="fileToUpfile4load" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>5. Bank statement of the latest three (3) months.</p>
                            </strong>
                            <input type="file" name="file5" id="file5" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>6. Original and Photocopy of Exit and Re-entry Visa.</p>
                            </strong>
                            <input type="file" name="file6" id="file6" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>7. Original and Photocopy of Passport.</p>
                            </strong>
                            <input type="file" name="file7" id="file7" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>8. Tickets or flight reservations indicating onward destination after the
                                    Philippines.
                                </p>
                            </strong>
                            <input type="file" name="file8" id="file8" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>9. Hotel Reservation or Letter of Invitation.</p>
                            </strong>
                            <input type="file" name="file9" id="file9" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>10. Original and photocopy of Police Clearance.</p>
                            </strong>
                            <input type="file" name="file10" id="file10" required>
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>11. Original and photocopy of Marriage Contract if married.</p>
                            </strong>
                            <input type="file" name="file11" id="file11">
                        </div>
                        <div class="form-floating mb-2 text-start">
                            <strong>
                                <p>12. Photocopy of passport of spouse.</p>
                            </strong>
                            <input type="file" name="file12" id="file12">
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-2">
                    <textarea class="form-control" placeholder="Leave a comment here" name="Remarks"
                        id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
            </div>
            <div class="col-md-1">

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
    $target_dir = "FILE_VISASERVICE/";
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
    $target_dir = "FILE_VISASERVICE/";
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
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file3"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file3"]["name"]);
        }else{
            exit;
        }
}
function file4(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file4"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file4"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file4"]["name"]);
        }else{
            exit;
        }
}
function file5(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file5"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file5"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file5"]["name"]);
        }else{
            exit;
        }
}
function file6(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file6"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file6"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file6"]["name"]);
        }else{
            exit;
        }
}
function file7(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file7"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file7"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file7"]["name"]);
        }else{
            exit;
        }
}
function file8(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file8"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file8"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file8"]["name"]);
        }else{
            exit;
        }
}
function file9(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file9"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file9"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file9"]["name"]);
        }else{
            exit;
        }
}
function file10(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file10"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file10"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file10"]["name"]);
        }else{
            exit;
        }
}
function file11(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file11"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file11"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file11"]["name"]);
        }else{
            exit;
        }
}
function file12(){
    $target_dir = "FILE_VISASERVICE/";
    $target_file = $target_dir  . basename($_FILES["file12"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         if (move_uploaded_file($_FILES["file12"]["tmp_name"], $target_file)) {
            return   basename($_FILES["file12"]["name"]);
        }else{
            exit;
        }
}

if(isset($_POST["btnSubmit"]))
{
    $date = date('Y-m-d H:i:s');
    $MyClass = new _visaservices();
    $MyClass->UserID         = $_SESSION['UserID'];
    $MyClass->File1      = file1();
    $MyClass->File2      = file2();
    $MyClass->File3     = file3();
    $MyClass->File4      = file4();
    $MyClass->File5      = file5();
    $MyClass->File6      = file6();
    $MyClass->File7      = file7();
    $MyClass->File8     = file8();
    $MyClass->File9     = file9();
    $MyClass->File10     = file10();
    $MyClass->File11     = file11();
    $MyClass->File12     = file12();
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
    $mail->Subject='SYSTEM NOTIFICATION: VISA SERVICE';
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