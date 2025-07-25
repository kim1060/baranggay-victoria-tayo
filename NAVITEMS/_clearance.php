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
                    <select class="form-select" name="FirstTimeJob" id="FirstTimeJob"
                        aria-label=".form-select-sm example" required>
                        <option value="">---</option>
                        <?php
                                    $sql = "SELECT * FROM `category`";
                                    $mydb->setQuery($sql);
                                    $cur = $mydb->loadResultList();
                                    foreach ($cur as $res) {
                                    echo '<option value='.$res->Category.'>'.$res->Category.'</option>';
                                    }
                            ?>
                    </select>
                    <label for="floatingSelect">First Time Job?</label>
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

function showPolicyModal(event) {
    event.preventDefault();
    const modalHtml = `
        <div class="modal" id="policyModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Appointment Policy</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please note that failure to attend your appointment on the scheduled date may result in penalties. Refunds are not applicable for missed appointments.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSubmit">Agree and Submit</button>
                    </div>
                </div>
            </div>
        </div>`;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modalElement = document.getElementById('policyModal');
    $(modalElement).modal('show');

    document.getElementById('confirmSubmit').addEventListener('click', function() {
        $(modalElement).modal('hide');
        const form = document.querySelector('form');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'btnModalSubmit';
        hiddenInput.value = 'true';
        form.appendChild(hiddenInput);
        form.submit();
    });

    modalElement.querySelector('.close').addEventListener('click', function() {
        $(modalElement).modal('hide');
    });

    modalElement.querySelector('.btn-secondary').addEventListener('click', function() {
        $(modalElement).modal('hide');
    });
}

// Attach the modal prompt to the submit button
const submitButton = document.querySelector('button[name="btnSubmit"]');
submitButton.addEventListener('click', showPolicyModal);
</script>
<?php



if(isset($_POST["btnModalSubmit"]))
{
    // Check for existing active appointment (prevent spam)
    $userID = $_SESSION['UserID'];

    // Simple check: Only prevent booking if there's an existing appointment with a future date
    $checkSql = "SELECT * FROM _clearance
                 WHERE UserID = {$userID}
                 AND DATE(AppointmentDate) >= CURDATE()
                 AND (Status = 'PENDING' OR Status = 'CONFIRMED' OR Status = 'APPROVED')
                 ORDER BY AppointmentDate DESC
                 LIMIT 1";

    $mydb->setQuery($checkSql);
    $existingAppointment = $mydb->loadSingleResult();

    // Only block if there's a future appointment
    if ($existingAppointment && isset($existingAppointment->ID)) {
        $existingDate = $existingAppointment->AppointmentDate;
        echo '<script type="text/javascript">
        swal({
            title: "Active Appointment Found!",
            text: "You have a pending clearance appointment on ' . $existingDate . '. Please wait for it to be processed or let the appointment date pass before booking a new one.",
            type: "warning",
            showConfirmButton: true,
            confirmButtonText: "Go to My List"
        },  function () {
            window.location.href = "index.php?view=myclearancelist";
        });
        </script>';
        return; // Stop execution
    }

    $date = date('Y-m-d H:i:s');
    $MyClass = new _clearance();
    $MyClass->UserID       = $_SESSION['UserID'];
    $MyClass->Comment      = $_POST['Remarks'];
    $MyClass->Status       = 'PENDING';
    $MyClass->Date         = $date ;
    $MyClass->AppointmentDate         = $_POST['AppointmentDate'] ;
    $MyClass->FirstTimeJob  = $_POST['FirstTimeJob'] ;
    $MyClass->Reason = "Default Reason"; // Provide a default value or retrieve from form input
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
    $mail->Subject='SYSTEM NOTIFICATION: BARANGAY CLEARANCE';
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