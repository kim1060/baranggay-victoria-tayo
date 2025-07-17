<div class="container">
    <h4 class="mt-3"><span class="bi-person-lock"></span> <?php echo $title;?></h4>
    <hr>
    <div class="rowmb-2">
        <div class="col-md-2">
            <a href="index.php?view=useradd" class="btn btn-sm btn-outline-success"><i class="bi-file-earmark-plus"></i>
                Add</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="table-responsive">
            <table id="userlist-table" class="table table-bordered table-sm table-hover datatable-auto">
                <thead class="table-dark">
                    <th class="text-center">#</th>
                    <th>Reference</th>
                    <th>Fullname</th>
                    <th>Username</th>
                    <th>User Type</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$sql = "SELECT UserID  ,Concat('REF ', LPAD(UserID  ,10,0)) as Reference,
							UserType,
							Username,
							Fullname
							FROM `user_account`";
					$mydb->setQuery($sql);
					$cur = $mydb->loadResultList();
					foreach ($cur as $result) {
						# code...
						echo '<tr>';
						echo '<td class="text-center">'.$i++.'</td>';
						echo '<td>'.$result->Reference.'</td>';
						echo '<td>'.$result->Fullname.'</td>';
						echo '<td>'.$result->Username.'</td>';
						echo '<td>'.$result->UserType.'</td>';
						echo '<td class="text-center">
						<a href="index.php?view=useredit&id='.$result->UserID.'" class="btn btn-sm btn-outline-primary"><i class="bi-pencil"></i></a>
						<!--<a data-id="'.$result->UserID.'" class="btn btn-sm btn-outline-danger delete_user"><i class="bi-trash"></i></a>-->
						</td>';
						echo '</tr>';
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".delete_user", function() {
  var PlaceOrderID = $(this).data('id');
   //alert(PlaceOrderID);
  $.ajax({
      type: "POST",
      url: "delete_user.php",
      dataType: "text",
      data: {
          PlaceOrderID: PlaceOrderID
      },
      success: function(data) {
          //  alert('Item Removed!');
          swal({
              title: "Command Executed!",
              text: "The record has been deleted.",
              type: "info",
              showConfirmButton: false,
              timer: 3000
          }, function() {
              //window.location.href = "index.php?view=questionlist";
              document.location.reload(true)
          });
      },
      error: function(result) {
          //alert('error');
      }
  });
});
</script>