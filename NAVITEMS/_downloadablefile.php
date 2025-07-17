<div class="container">
    <h4 class="mt-3"><span class="bi-journal-check"></span> <?php echo $title;?></h4>

    <div class="rowmb-2">
    </div>
    <hr>
    <div class="row">
        <div class="table-responsive">
            <table id="downloadable-table" class="table table-bordered table-sm table-hover datatable-auto">
                <thead class="table-dark">
                    <th class="text-center">#</th>
                    <th>Filename</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody>
                    <?php
					$i = 1;
					$sql = "SELECT ID  ,Concat('REF ', LPAD(ID  ,10,0)) as Reference,
							Filename
							FROM `downloadablefile`";
					$mydb->setQuery($sql);
					$cur = $mydb->loadResultList();
					foreach ($cur as $result) {
						# code...
						echo '<tr>';
						echo '<td class="text-center">'.$i++.'</td>';
                        echo '<td>'.$result->Filename.'</td>';

                            echo '<td class="text-center">
                            <!--<a href="index.php?view=frbudgetedit&id='.$result->ID.'" class="btn btn-sm btn-outline-primary"><i class="bi-pencil"></i></a>-->
                            <a href="./FILE_DOWNLOADABLE/'.$result->Filename.'" class="btn btn-outline-primary btn-sm" download><i class="bi-download"></i></a>
                            <!--<a data-id="'.$result->ID.'" class="btn btn-sm btn-outline-danger delete_user"><i class="bi-trash"></i></a>-->
                            </td>';


						echo '</tr>';
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <h5>Delete the selected Record?</h5>

                    <input type="hidden" class="form-control" name="idkl" id="idkl" value="">

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
    $('#delete_').modal('show');
});
</script>

<?php

if(isset($_POST["btnSubmit"]))
{
    $MyClass = new downloadablefile();
    $id         = $_POST['idkl'];
    $MyClass->delete( $id);
    $sql = "SELECT * FROM `downloadablefile` WHERE ID=$id ";
    $mydb->setQuery($sql);
    $cur = $mydb->loadResultList();

    foreach ($cur as $result) {
    unlink("FILE_DOWNLOADABLE/$result->Filename") ;
    }

    echo '<script type="text/javascript">
    swal({
        title: "Record Deleted!",
        text: "Record has been deleted.",
        type: "info",
        showConfirmButton: false,
        timer: 2500
    },  function () {
        window.location.href = "index.php?view=formlist";
    });
    </script>';
}
?>