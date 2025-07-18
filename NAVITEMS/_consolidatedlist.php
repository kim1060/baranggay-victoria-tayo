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
            <table class="table table-bordered table-sm table-hover">
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

					// Check which tables exist
					$existingTables = [];
					$tablesToCheck = [
						'_clearance' => 'CLEARANCE',
						'_cedula' => 'CEDULA',
						'_court' => 'COURT',
						'_indigency' => 'INDIGENCY',
						'_permit' => 'BUSINESS PERMIT'
					];

					foreach($tablesToCheck as $table => $label) {
						$tableCheck = "SHOW TABLES LIKE '$table'";
						$mydb->setQuery($tableCheck);
						$tableExists = $mydb->loadSingleResult();
						if ($tableExists) {
							$existingTables[$table] = $label;
						}
					}

					// Build dynamic SQL query only for existing tables
					$sqlParts = [];
					foreach($existingTables as $table => $label) {
						$sqlParts[] = "SELECT
							a.ID,
							CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
							a.`Status`,
							DATE_FORMAT(a.Date,'%M %d, %Y') as Dates,
							a.Date as SortDate,
							'$label' as TransactionType
							FROM $table a
							JOIN user_account b on b.UserID=a.UserID";
					}

					if (!empty($sqlParts)) {
						$sql = implode(' UNION ALL ', $sqlParts) . " ORDER BY SortDate DESC";
						$mydb->setQuery($sql);
						$cur = $mydb->loadResultList();
					} else {
						$cur = [];
					}

					foreach ($cur as $result) {
						# code...
						echo '<tr>';
                        echo '<td class="text-center">'.$i++.'</td>';
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
                        elseif($result->Status=='PAID')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-success">PAID</span></td>';
                        }
                        elseif($result->Status=='CANCELLED')
                        {
                            echo '<td class="text-center"><span class="badge text-bg-danger">CANCELLED</span></td>';
                        }
                        else
                        {
                            // Show the actual status for any unhandled cases
                            echo '<td class="text-center"><span class="badge text-bg-warning">'.htmlspecialchars($result->Status).'</span></td>';
                        }
                        echo '<td>'.$result->Dates.'</td>';
                        echo '<td>'.$result->TransactionType.'</td>';
						echo '</tr>';
					}

					// Show message if no transactions found
					if (empty($cur)) {
						echo '<tr class="empty-message"><td colspan="5" class="text-center text-muted py-4">
							<i class="bi bi-inbox" style="font-size: 2rem;"></i><br>
							No transactions found.<br>
							<small class="text-muted">Available tables: ' . implode(', ', array_keys($existingTables)) . '</small>
						</td></tr>';
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

// Prevent DataTables auto-initialization on tables without id="example"
$(document).ready(function() {
    // Only initialize DataTables if the table has content and proper structure
    if ($('table tbody tr').length > 1 || ($('table tbody tr').length === 1 && !$('table tbody tr').hasClass('empty-message'))) {
        // Table has data, can safely initialize DataTables if needed
        console.log('Table ready for DataTables');
    }
});
</script>

<?php

if(isset($_POST["btnSubmit"]))
{
    $d=$_POST['AppointmentDates'];

    // Check appointment count across all existing tables
    $maxrow = 0;
    $existingTables = ['_clearance', '_cedula', '_court', '_indigency', '_permit'];

    foreach($existingTables as $table) {
        $tableCheck = "SHOW TABLES LIKE '$table'";
        $mydb->setQuery($tableCheck);
        $tableExists = $mydb->loadSingleResult();

        if ($tableExists) {
            $sql = "SELECT * FROM `$table` WHERE AppointmentDate ='$d'";
            $mydb->setQuery($sql);
            $row = $mydb->executeQuery();
            $maxrow += $mydb->num_rows($row);
        }
    }

    if ($maxrow > 10) {
        echo '<script type="text/javascript">
        swal({
            title:"Maximum appointment reach!",
            text: "Maximum appointments per day reached.",
            type: "warning",
            showConfirmButton: false,
            timer: 2500
        });
        </script>';
    }
    else{
        echo '<script type="text/javascript">
        swal({
            title: "Date Available!",
            text: "This date is available for appointment scheduling.",
            type: "success",
            showConfirmButton: true
        });
        </script>';
    }
}
?>