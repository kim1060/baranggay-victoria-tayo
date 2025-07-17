<?php
require_once("INCLUDE/initialize.php");
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
            <table id="court-mylist-table" class="table table-bordered table-sm table-hover datatable-auto">
                <thead class="table-dark">
                    <th class="text-center">#</th>
                    <!-- <th>ID</th> -->
                    <th>Fullname</th>
                    <th class="text-center">Status</th>
                    <th>Appointment Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Submitted Date</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    <?php
					$i = 1;
                    $ID=$_SESSION['UserID'];
					$sql = "SELECT
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.AppointmentDate,'%M %d, %Y') as AppointmentDate,
                            DATE_FORMAT(a.ApprovedDate,'%M %d, %Y')  as ApprovedDate,
                            REPLACE(a.PaymentReference,'https://pm.link/Appointmate/test/','') as PaymentReference,
                            TIME_FORMAT(a.FromTime, '%h:%i %p') as TimeFrom,
                            TIME_FORMAT(a.ToTime, '%h:%i %p') as TimeTo,
                            a.Reason,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates
							FROM _court a
                            JOIN user_account b on b.UserID=a.UserID WHERE a.UserID=$ID";
					$mydb->setQuery($sql);
					$cur = $mydb->loadResultList();
					foreach ($cur as $result) {
						# code...
						echo '<tr>';
						echo '<td class="text-center">'.$i++.'</td>';
                        // echo '<td>'.$result->ID.'</td>';
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
                         elseif($result->Status=='CANCELLED')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-danger">CANCELLED</span></td>';
                        }
                        elseif($result->Status=='REQUEST FOR CANCEL')
                        {
                              echo '<td class="text-center">
                              <span class="badge text-bg-secondary">REQUEST FOR CANCEL</span>
                              </td>';
                        }
                        else
                        {

                        }
                        echo '<td>'.$result->AppointmentDate.'</td>';
                        echo '<td>'.$result->TimeFrom.'</td>';
                        echo '<td>'.$result->TimeTo.'</td>';
                        echo '<td>'.$result->Dates.'</td>';
                        if($result->Status=='PENDING')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-secondary">WAIT FOR CONFIRMATION</span></td>';
                        }

                        elseif($result->Status=='CONFIRMED' && $result->ApprovedDate==NULL)
                        {
                            echo '<td class="text-center">
                            <a href="index.php?view=paymentcourt&id='.$result->ID.'" target="_blank" class="btn btn-sm btn-outline-success"><span class="bi-credit-card"> PROCEED TO PAYMENT</span></a>
                            </td>';
                        }
                        elseif($result->Status=='CANCELLED')
                        {
                              echo '<td class="text-center">
                              <span class="badge text-bg-danger">CANCELLED</span>
                              </td>';
                        }
                        else
                        {
                              echo '<td class="text-center">
                              <span class="badge text-bg-success">PAID</span> <br>
                                  <strong>Date: </strong>'.$result->ApprovedDate.' <br>
                               <strong>Reference: </strong>'.$result->PaymentReference.'
                              </td>';
                        }

                         if($result->Status=='CANCELLED')
                        {
                              echo '<td class="text-center">

                              </td>';
                        }
                        elseif($result->Status=='REQUEST FOR CANCEL')
                        {
                              echo '<td class="text-center">
                              <span class="badge text-bg-secondary">REQUEST FOR CANCEL</span>
                              </td>';
                        }
                        else{
                            echo '<td class="text-center">
                            <a title="Cancel" data-id='.$result->ID.' data-bs-toggle="modal"
                            data-bs-target="#delete_announcement" class="btn btn-sm btn-outline-danger passID"><i
                                class="bi-x-circle"></i> CANCEL</a>
                         </td>';


                        }
                        echo '</tr>';
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_announcement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <h5>Cancel the selected Record?</h5>

                    <input type="hidden" class="form-control" name="idkl" id="idkl" value="">
                    <div class="form-floating">

                        <textarea class="form-control" id="floatingTextarea2" name="Reason"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Reason</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnSubmit" class="btn btn-success">YES</button>
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
</script>

<?php

if(isset($_POST["btnSubmit"]))
{

    $MyClass = new _court();
    $id         = $_POST['idkl'];
    $MyClass->Reason = $_POST['Reason'];
   $MyClass->Status = "REQUEST FOR CANCEL";
    $MyClass->update($id);

        echo '<script type="text/javascript">
        swal({
            title:"Request for Cancel!",
            text: "The selected record has been submitted for cancellation.",
            type: "info",
            showConfirmButton: false,
            timer: 2500
        },  function () {
        window.location.href = "index.php?view=mycourtlist";
    });
    </script>';

}
?>