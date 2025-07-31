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
                    <select class="form-select" name="PurposeType" id="PurposeType" required>
                        <option value="">Select Purpose</option>
                        <option value="Job Requirement">Job Requirement</option>
                        <option value="Business Permit">Business Permit</option>
                        <option value="Police Clearance">Police Clearance</option>
                        <option value="Legal Requirement">Legal Requirement</option>
                        <option value="Etc... or specify">Etc... or specify</option>
                    </select>
                    <label for="PurposeType">Purpose</label>
                </div>
                <div class="form-floating mb-2" id="customPurposeDiv" style="display: none;">
                    <input type="text" class="form-control" name="CustomPurpose" id="CustomPurpose" placeholder="Specify your purpose">
                    <label for="CustomPurpose">Specify Purpose</label>
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

// Handle purpose dropdown change
document.getElementById('PurposeType').addEventListener('change', function() {
    const customPurposeDiv = document.getElementById('customPurposeDiv');
    const customPurposeInput = document.getElementById('CustomPurpose');

    if (this.value === 'Etc... or specify') {
        customPurposeDiv.style.display = 'block';
        customPurposeInput.required = true;
    } else {
        customPurposeDiv.style.display = 'none';
        customPurposeInput.required = false;
        customPurposeInput.value = '';
    }
});
</script>
<?php



if(isset($_POST["btnModalSubmit"]))
{
    // Check for existing active appointment (prevent spam)
    $userID = $_SESSION['UserID'];
    $checkSql = "SELECT * FROM _indigency
                 WHERE UserID = {$userID}
                 AND DATE(AppointmentDate) >= CURDATE()
                 AND (Status = 'PENDING' OR Status = 'CONFIRMED' OR Status = 'APPROVED')
                 ORDER BY AppointmentDate DESC
                 LIMIT 1";
    $mydb->setQuery($checkSql);
    $existingAppointment = $mydb->loadSingleResult();

    if ($existingAppointment && isset($existingAppointment->ID)) {
        $existingDate = $existingAppointment->AppointmentDate;
        echo '<script type="text/javascript">
        swal({
            title: "Active Appointment Found!",
            text: "You have a pending indigency appointment on ' . $existingDate . '. Please wait for it to be processed or let the appointment date pass before booking a new one.",
            type: "warning",
            showConfirmButton: true,
            confirmButtonText: "Go to My List"
        },  function () {
            window.location.href = "index.php?view=myindigencylist";
        });
        </script>';
        return; // Stop execution
    }




    $date = date('Y-m-d H:i:s');
    $MyClass = new _indigency();
    $MyClass->UserID       = $_SESSION['UserID'];
    // Determine the purpose based on selection
    $purpose = $_POST['PurposeType'];
    if ($purpose === 'Etc... or specify') {
        $purpose = $_POST['CustomPurpose'];
    }
    $MyClass->Comment      = $purpose;
    $MyClass->Status       = 'PENDING';
    $MyClass->Date         = $date ;
    $MyClass->AppointmentDate         = $_POST['AppointmentDate'] ;
    $MyClass->Reason = "Certificate of Indigency";
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
<script>
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