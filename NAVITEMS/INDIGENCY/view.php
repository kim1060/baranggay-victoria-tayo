<?php 
require_once("include/initialize.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$id = 	$_GET['id'];
$AppDate="";
//TRANSACTION DETAILS
$MyClass = New _indigency();
$res = $MyClass->single_data($id);

$ID = $res->ID;
$UserID=$res->UserID;
$DocStatus=$res->Status;
$AppointmentDate=$res->AppointmentDate;
$dd = strtotime($AppointmentDate);
$Comment = $res->Comment;
$Reason = $res->Reason;
//USER DETAILS
$MyClass = New UserAccount();
$res = $MyClass->single_data($UserID);
$Lastname = $res->Lastname;
$Firstname = $res->Firstname;
$Middlename = $res->Middlename;
$Address = $res->Address;
$Age = $res->Age;
$Status = $res->Status;
$Citizenship = $res->Citizenship;
$Email = $res->Email;
$Contact = $res->Contact;
$Filename = $res->Filename;
?>

<div class="container mb-4">
    <form method="post">
        <div class="row mt-3">
            <h4><span class="bi-person-exclamation"></span> <?php echo $title;?></h4>
            <hr>
            <div class="row">
                <div class="col-md-4">

                    <img src="./IMG/<?php echo $Filename ?>" class="img-fluid rounded-start img-1 border border-dark"
                        alt="..." style="height: 255px; width: 100%;" />
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Lastname ?>" name="Lastname"
                                    id="Lastname" placeholder="Lastname" required>
                                <label for="floatingInput">Lastname</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Firstname ?>"
                                    name="Firstname" id="Firstname" placeholder="Firstname" required>
                                <label for="floatingInput">Firstname</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Middlename ?>"
                                    name="Middlename" id="Middlename" placeholder="Middlename" required>
                                <label for="floatingInput">Middlename</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Address ?>" name="Address"
                                    id="Address" placeholder="Address" required>
                                <label for="floatingInput">Address</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating mb-2 text-start">
                                        <input type="text" class="form-control" value="<?php echo $Age ?>" name="Age"
                                            id="Age" placeholder="Age" required>
                                        <label for="floatingInput">Age</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-floating text-start mb-2">
                                        <select class="form-select" name="Status" id="Status"
                                            aria-label=".form-select-sm example" required>

                                            <?php 
                                        $sql = "SELECT * FROM `civilstatus` where CivilStatus='$Status'";
                                        $mydb->setQuery($sql);
                                        $cur = $mydb->loadResultList();
                                        foreach ($cur as $res) {
                                            # code...
                                            echo '<option value='.$res->CivilStatus.'>'.$res->CivilStatus.'</option>';
                                        } 
                                    ?>
                                            <?php 
                                        $sql = "SELECT * FROM `civilstatus` where CivilStatus<>'$Status'";
                                        $mydb->setQuery($sql);
                                        $cur = $mydb->loadResultList();
                                        foreach ($cur as $res) {
                                        echo '<option value='.$res->CivilStatus.'>'.$res->CivilStatus.'</option>';
                                        }                                    
                                    ?>
                                        </select>
                                        <label for="floatingSelect">Status</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="Email" class="form-control" value="<?php echo $Email ?>" name="Email"
                                    id="Email" placeholder="Email" required>
                                <label for="floatingInput">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Citizenship ?>"
                                    name="Citizenship" id="Citizenship" placeholder="Citizenship" required>
                                <label for="floatingInput">Citizenship</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Contact ?>" name="Contact"
                                    id="Contact" placeholder="Mobile #" maxlength="11"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    required>
                                <label for="floatingInput">Mobile #</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>






        </div>


        <h4><span class="bi-info-circle"></span> Appointment Details</h4>
        <hr>

        <h4>
            Certificate of Indigency
        </h4>
        <strong>Purpose:</strong> <?php echo $Comment ?>
        <br>
        <strong>Appointment Date:</strong> <?php echo date('l F d, Y', $dd) ?>
        <hr>
        <strong>Status:</strong> <?php echo $DocStatus ?>
        <br>
        <strong>Reason:</strong> <?php echo $Reason ?>

        <div class="row g-1 mb-4 text-center">
            <div class="col-12">
                <?php 
                if($_SESSION['UserType']=='ADMIN'){
                ?>

                <?php 
                    if($DocStatus=='CONFIRMED' && $AppointmentDate==NULL){
                ?>
                <?php 
                    }elseif($DocStatus=='CONFIRMED' && $AppointmentDate!==NULL){
                ?>
                <?php 
                    }elseif($DocStatus=='REQUEST FOR CANCEL'){
                ?>
                <button type="submit" name="btnCancel" class="btn btn-outline-secondary btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Confirm Cancel</button>
                <?php 
                    }elseif($DocStatus=='PENDING'){      
                ?>
                <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Confirm</button>
                <?php }?>
                <a href="index.php?view=indigencylist"><button type="button" class="btn btn-outline-danger btn-sm"><span
                            class="bi-arrow-left"></span> Back</button></a>
                <?php 
                }else{
                ?>
                <a href="index.php?view=myindigencylist"><button type="button"
                        class="btn btn-outline-danger btn-sm"><span class="bi-arrow-left"></span> Back</button></a>
                <?php }?>
            </div>
        </div>
    </form>
    <form method="POST" action="printindigency.php" target="_blank">
        <div class="text-center">
            <input type="hidden" class="form-control" value="<?php echo $id ?>" name="id" id="id" placeholder="id"
                required>
            <button type="submit" name="btnPrint" class="btn btn-outline-primary btn-sm "><span
                    class="bi-printer"></span>
                Print</button>
        </div>

    </form>
</div>
<br>
<?php
if(isset($_POST["btnSubmit"]))
{
        $date = date('Y-m-d H:i:s');
        $Users = new _indigency();
        $Users->Status         = "CONFIRMED";
        $Users->ConfirmDate         = $date;
        $Users->update($ID);
        

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
        $mail->addAddress($Email);
        $mail->isHTML(true);
        $mail->Subject='SYSTEM NOTIFICATION: CERTIFICATE OF INDIGENCY';
        $mail->Body='<HTML>Good Day! Your appointment has been confirmed. You can visit our Barangay Office on '. date('l F d, Y', $dd) .' within office hour. Thank you!</HTML>';
        $mail->send();

        echo '<script type="text/javascript">
        swal({
            title: " Confirmed!",
            text: "Appointment has been successfully confirmed",
            type: "success",
            showConfirmButton: true
        },  function () {
            window.location.href = "index.php?view=indigencylist";
        });
        </script>';
  
  
}

if(isset($_POST["btnSubmitApproved"]))
{
        $date = date('Y-m-d H:i:s');
        $Users = new _indigency();
        $Users->Status         = "APPROVED";
        $Users->ApprovedDate         = $date;
        $Users->update($ID);
        

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
        $mail->addAddress($Email);
        $mail->isHTML(true);
        $mail->Subject='SYSTEM NOTIFICATION: CERTIFICATE OF INDIGENCY';
        $mail->Body='<HTML>Good Day! Your appointment on '.$AppDate.' 8AM has been approved. See you at the office, Thank you.</HTML>';
        $mail->send();

        echo '<script type="text/javascript">
        swal({
            title: "Appointment Approved!",
            text: "The appointment has been successfully approved",
            type: "success",
            showConfirmButton: true
        },  function () {
            window.location.href = "index.php?view=indigencylist";
        });
        </script>';
  
  
}

if(isset($_POST["btnCancel"]))
{
        $date = date('Y-m-d H:i:s');
        $Users = new _indigency();
        $Users->Status         = "CANCELLED";
        $Users->CancelDate         = $date;
        $Users->update($ID);

                echo '<script type="text/javascript">
        swal({
            title: "Appointment Cancelled!",
            text: "The appointment has been cancelled",
            type: "success",
            showConfirmButton: true
        },  function () {
            window.location.href = "index.php?view=indigencylist";
        });
        </script>';
}
?>