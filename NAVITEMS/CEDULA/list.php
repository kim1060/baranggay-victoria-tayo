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
            <table id="cedula-list-table" class="table table-bordered table-sm table-hover datatable-auto">
                <thead class="table-dark">
                    <th class="text-center">#</th>
                    <!-- <th>ID</th> -->
                    <th>Fullname</th>
                    <th class="text-center">Status</th>
                    <th>Appointment Date</th>
                    <th>Submitted Date</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$sql = "SELECT
                            a.ID,
                            CONCAT(b.Lastname,', ',b.Firstname,' ',b.Middlename) as Fullname,
                            a.`Status`,
                            DATE_FORMAT(a.AppointmentDate,'%M %d, %Y') as AppointmentDate,
                            DATE_FORMAT(a.Date,'%M %d, %Y') as Dates
							FROM _cedula a
                            JOIN user_account b on b.UserID=a.UserID ";
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
                            elseif($result->Status=='PAID')
                            {
                                echo '<td class="text-center"><span class="badge text-bg-success">PAID</span></td>';
                            }
                            elseif($result->Status=='CANCELLED')
                            {
                                echo '<td class="text-center"><span class="badge text-bg-danger">CANCELLED</span></td>';
                            }
                            elseif($result->Status=='REQUEST FOR CANCEL')
                            {
                                echo '<td class="text-center"><span class="badge text-bg-secondary">REQUEST FOR CANCEL</span></td>';
                            }
                            else
                            {

                            }
                            echo '<td>'.$result->AppointmentDate.'</td>';
                            echo '<td>'.$result->Dates.'</td>';
                        echo '<td class="text-center">
                        <a href="index.php?view=cedulaview&id='.$result->ID.'" class="btn btn-sm btn-outline-primary"><span class="bi-eye"> VIEW DETAILS</span></a>
                         </td>';
						echo '</tr>';
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>