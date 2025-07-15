<?php
require_once("include/initialize.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<div class="container">
    <h4 class="mt-3"><span class="bi-journal-check"></span> <?php echo $title;?></h4>
    <!-- <hr>
    <div class="rowmb-2">
        <div class="col-md-2">
            <a href="index.php?view=formadd" class="btn btn-sm btn-outline-success"><i class="bi-file-earmark-plus"></i>
                Add</a>
        </div>
    </div> -->
    <hr>
    <div class="row">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-sm table-hover">
                <thead class="table-dark">
                    <th class="text-center">#</th>
                    <th>Fullname</th>
                    <th class="text-center">Status</th>
                    <th>Date</th>
                    <th>Transaction Type</th>
                </thead>
                <tbody>
                    <?php 
					$i = 1;
                    $ID=$_SESSION['UserID'];
					$sql = "SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'CERTIFICATION' as TransactionType
							FROM _certificationdocument a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'NOTARIAL SERVICE' as TransactionType
							FROM _notarialservices a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'OTHER SERVICE' as TransactionType
							FROM _otherservices a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'RENEWAL OF PASSPORT' as TransactionType
							FROM _renewalofpassport a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'REPORT OF BIRTH' as TransactionType
							FROM _reportofbirth a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'REPORT OF MARRIAGE' as TransactionType
							FROM _reportofmarriage a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            UNION
                            SELECT 
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
                            'VISA SERVICE' as TransactionType
							FROM _visaservices a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.`Status`='APPROVED'
                            ";
					$mydb->setQuery($sql);
					$cur = $mydb->loadResultList();
					foreach ($cur as $result) {
						# code...
						echo '<tr>';
                        echo '<td>'.$result->ID.'</td>';
                        echo '<td>'.$result->Fullname.'</td>';
                        if($result->Status=='PENDING')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-secondary">PENDING</span></td>';
                        }
                        elseif($result->Status=='CONFIRMED')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-primary">CONFIRMED</span></td>';
                        }
                        elseif($result->Status=='APPROVED')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-success">APPROVED</span></td>';
                        }
                        else
                        {
                            
                        }
                        echo '<td>'.$result->Dates.'</td>';
                        echo '<td>'.$result->TransactionType.'</td>';
						echo '</tr>';
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="appointmentdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select date for appointment.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <input type="hidden" class="form-control" name="idkl" id="idkl">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" name="AppointmentDates" id="datetimepicker2"
                            onfocus="disablePastDates()">
                        <label for="floatingInput">Date</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnSubmit" class="btn btn-success">SUBMIT</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).on("click", ".passID", function() {
    var itemid = $(this).data('id');
    $("#idkl").val(itemid);
    $('#appointmentdate').modal('show');
});


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

    $d=$_POST['AppointmentDates'];
    $sql = "SELECT * FROM `_certificationdocument` WHERE 1=1 and AppointmentDate ='$d'";
    $mydb->setQuery($sql);
    $row = $mydb->executeQuery();
    $maxrow = $mydb->num_rows($row);  

    if ($maxrow > 2) {
        echo '<script type="text/javascript">
        swal({
            title:"Maximum appointment reach!",
            text: "Maximum of 3 number of appointment per day.",
            type: "warning",
            showConfirmButton: false,
            timer: 2500
        });
        </script>';
    } 
    else{



    $MyClass = new _certificationdocument();
    $id         = $_POST['idkl'];
    $MyClass->AppointmentDate = $_POST['AppointmentDates'];
    $MyClass->update($id);

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
    $mail->Subject='SYSTEM NOTIFICATION: CERTIFICATION';
    $mail->Body='<HTML>Hi, Good Day! You have just scheduled an appointment at '.$_POST['AppointmentDates'].' at exactly 8am. Please kindly bring necessary documents. Thank you!</HTML>';
    $mail->send();

    echo '<script type="text/javascript">
    swal({
        title: "Appointmet Submitted!",
        text: "Congratulations you have now scheduled an appointment at the immigration office at Alradeef St, Al Safarat, Riyadh 12512, Saudi Arabia on '.$_POST['AppointmentDates'].' 8:00 am. For further questions you may contact the office at the following number: TEL: (0096611) 482-3559. Fax: (0096611) 488-3945",
        type: "success",
        showConfirmButton: true
    },  function () {
        window.location.href = "index.php?view=mycertificationlist";
    });
    </script>';
    }
}
?>