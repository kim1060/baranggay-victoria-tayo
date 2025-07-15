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
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
                <div class="form-floating mb-2">
                    <input type="date" class="form-control" name="AppointmentDate" id="datetimepicker2"
                        onfocus="disablePastDates()" required>
                    <label for="floatingInput">Appointment Date</label>
                </div>
                <div class="form-floating mb-2">
                    <textarea class="form-control" placeholder="Purpose" name="Remarks" id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Purpose</label>
                </div>
            </div>
            <div class="col-md-4">

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
<script>
function disablePastDates() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("datetimepicker2").setAttribute("min", today);
}
</script>
<?php



if(isset($_POST["btnSubmit"]))
{
   

        

    $date = date('Y-m-d H:i:s');
    $MyClass = new _indigency();
    $MyClass->UserID       = $_SESSION['UserID'];
    $MyClass->Comment      = $_POST['Remarks'];
    $MyClass->Status       = 'PENDING';
    $MyClass->Date         = $date ;
    $MyClass->AppointmentDate         = $_POST['AppointmentDate'] ;
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
    $mail->Subject='SYSTEM NOTIFICATION: CERTIFICATE OF INDIGENCY';
    $mail->Body='<HTML>Good Day! We have received your appointment. Please wait on our confirmation, we will notify you via Email. Thank you!</HTML>';
    $mail->send();
    //\r\n\r\n
    echo '<script type="text/javascript">
    swal({
        title: "Submitted!",
        text: "Please wait on our confirmation, we will notify you via Email. Thank you so much and have a blessed day!",
        type: "success",
        showConfirmButton: true
    },  function () {
        window.location.href = "index.php?view=home";
    });
    </script>';


}

?>