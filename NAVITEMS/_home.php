<!-- <div class="container-fluid">
    <div class="webheader" data-aos="fade-down" data-aos-duration="2500">
        <img src="IMG/DILG_BANNER.png" class="d-block w-100" alt="...">
    </div>
</div> -->
<?php
    // $ch = curl_init();
	// $parameters = array(
	// 		'apikey' => '06f202f323dc165c1809c5310e339a17',
	// 		'number' => '09159205929',
	// 		'message' => 'TEST MESSAGE',
	// 		'sendername' => 'SEMAPHORE'
	// 		);
	// 		curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
	// 		curl_setopt( $ch, CURLOPT_POST, 1 );
	// 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    //         //Send the parameters set above with the request
    //         curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

    //         $result = curl_exec($ch);

    //         print_r($result);
    //         if (curl_errno($ch)) {
    //            $error_msg = curl_error($ch);
    //            print_r($error_msg);
    //         }

    //         curl_close($ch);
   require_once("INCLUDE/initialize.php");
if(isset($_SESSION['UserID'])){
$UserID=$_SESSION['UserID'];
}

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
//     $mail = new PHPMailer(true);
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'thesiswebsite2024@gmail.com';
//     $mail->Password = 'ylku vutf rqsi jzfy';
//     $mail->SMTPSecured = 'ssl';
//     $mail->Port = 587;
//     $mail->setFrom('thesiswebsite2024@gmail.com');
//     $mail->addAddress('reyeskeb17@gmail.com');
//     $mail->isHTML(true);
//     $mail->Subject='SYSTEM NOTIFICATION';
//     $mail->Body='<HTML>TEST EMAIL</HTML>';
//     $mail->send();
?>

<div class="container mb-5">


    <div class="row mt-3" data-aos="fade-left " data-aos-duration="2500">
        <?php

            if(isset($_SESSION['UserID'])){
                if($_SESSION['UserType']=="ADMIN"){
        ?>
        <h4><span class="bi-list-check"> </span> Appointment</h4>
        <hr>
        <div class="row row-cols-1 row-cols-md-5 g-2 mb-3">
            <div class="col">
                <div class="card bg-primary text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Barangay Clearance</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where AppointmentDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where ConfirmDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where ApprovedDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=clearancelist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-success text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Cedula</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where AppointmentDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where ConfirmDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where ApprovedDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=cedulalist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Certificate of Indigency</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where AppointmentDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where ConfirmDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where ApprovedDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=indigencylist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-warning text-dark border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Business Permit</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where AppointmentDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where ConfirmDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where ApprovedDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=permitlist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-info text-dark border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Court Booking</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _court where AppointmentDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _court where ConfirmDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _court where ApprovedDate IS NOT NULL";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=courtlist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <?php }}?>
    <div class="row mt-3">
        <?php
            if(isset($_SESSION['UserID'])){
                if($_SESSION['UserType']=="USER"){
        ?>
        <h4><span class="bi-list-check"> </span> My Appointment</h4>
        <hr>
        <div class="row row-cols-1 row-cols-md-5 g-2 mb-3">
            <div class="col">
                <div class="card bg-primary text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Barangay Clearance</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where AppointmentDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where ConfirmDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _clearance where ApprovedDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=myclearancelist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-success text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Cedula</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where AppointmentDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where ConfirmDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _cedula where ApprovedDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=mycedulalist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger text-white border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Certificate of Indigency</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where AppointmentDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where ConfirmDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _indigency where ApprovedDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=myindigencylist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-warning text-dark border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Business Permit</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where AppointmentDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where ConfirmDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _permit where ApprovedDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=mypermitlist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-info text-dark border-dark">
                    <div class="card-body">
                        <h2><span class="bi-card-checklist"></span></h2>
                        <h5 class="card-title">Court Booking</h5>
                        <?php
                        $sql = "SELECT coalesce(count(*),0) as count from _court where AppointmentDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Pending = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _court where ConfirmDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Confirmed = $result->count;
                        }
                        $sql = "SELECT coalesce(count(*),0) as count from _court where ApprovedDate IS NOT NULL AND UserID='$UserID'";
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result)
                        {
                            $Done = $result->count;
                        }
                    ?>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-hourglass-bottom"></span> Pending</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Pending ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-circle"></span> Confirmed</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Confirmed ?></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <strong><span class="bi-check-all"></span> Done/Paid</strong>
                            </div>
                            <div class="col-md-4">
                                <strong><?php echo $Done ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="index.php?view=mycourtlist" class="btn btn-light text-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <?php }}?>
    <div class="row">

        <!-- <section>
            <div class="row mt-4" data-aos="fade-right" data-aos-duration="2500">
                <h2 class="text-center">APPOINTMATE: A WEB-BASED APPOINTMENT SYSTEM</h2>

                <div class="row">
                    <div class="col-md-6">
                        <img src="IMG/IMAGE1.PNG" class="img-fluid" alt="...">
                    </div>
                    <div class="col-md-6">
                        <img src="IMG/IMAGE2.PNG" class="img-fluid" alt="...">
                    </div>
                </div>
                <p class="mb-4 mt-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                    the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of
                    type and
                    scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap
                    into electronic typesetting, remaining essentially unchanged.
                </p>
            </div>
        </section> -->


        <section data-aos="fade-left " data-aos-duration="2500">
            <h4><span class="bi-megaphone"> </span> Announcement</h4>
            <hr>
            <div class="row">
                <div class="col-md-12">

                    <div class="card-body">
                        <?php
                            $db = new Database();
                            $qry = mysqli_query($db->conn, "SELECT *,date_format(DateCreated, '%M %e, %Y [%r]') as DateCreateds from announcement");
                            while ($row = $qry->fetch_assoc()) :
                            $Filename = $row['Filename'];
                        ?>
                        <div class="card mb-2">
                            <div class="row g-0">
                                <div class="col-md-3">
                                    <img src="./NEWS_IMAGE/<?php echo $Filename ?>"
                                        class="img-fluid rounded-start img-1" alt="..."
                                        style="height: 200px; width: 250px;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <p class="card-text"><small class="text-muted">Posted by:
                                                <?php echo $row['CreatedBy']?></small>
                                        </p>
                                        <h5 class="card-title"><?php echo $row['Title'] ?></h5>
                                        <p class="card-text"><?php echo $row['Details'] ?>
                                        </p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <?php echo $row['DateCreateds']?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php endwhile; ?>


                    </div>

                </div>
            </div>
        </section>

    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
</script>