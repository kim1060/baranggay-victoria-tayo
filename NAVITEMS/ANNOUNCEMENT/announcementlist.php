<head>
    <meta charset="utf-8">

    <meta name="description" content="">
    <style>
    select.form-control {
        display: inline;
        width: 200px;
        margin-left: 25px;
    }

    .product {
        position: relative;
        box-shadow: 0 0 2em rgba(0, 0, 0, 0.2);
        border-radius: 1em;
        overflow: hidden;
    }

    .img-1 {
        width: 100%;
        z-index: 0;
    }

    .img-2 {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 2;
    }

    .color {
        background: #f5f0f0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        mix-blend-mode: multiply;
    }

    .card {
        width: 25rem;
        border-radius: 10px;
        margin: 20px 15px;
    }
    </style>

</head>
<div class="container">
    <h4 class="mt-3"><span class="bi-megaphone"></span>
        <?php echo $title ?></h4>
    <hr>
    <div class="rowmb-2">
        <div class="col-md-2">
            <a href="index.php?view=announcementadd" class="btn btn-sm btn-outline-success"><i
                    class="bi-file-earmark-plus"></i>
                Add</a>
        </div>
    </div>
    <hr>

    <div class="row">

        <?php
                    $db = new Database();
                    $qry = mysqli_query($db->conn, "SELECT *,date_format(DateCreated, '%M %e, %Y [%r]') as DateCreateds from announcement");
                    while ($row = $qry->fetch_assoc()) :
                    $Filename = $row['Filename'];
                ?>

        <div class="card mb-2" style="width: 98%;">
            <div class="row g-0">
                <div class="col-md-3">
                    <img src="./NEWS_IMAGE/<?php echo $Filename ?>" class="img-fluid rounded-start img-1" alt="..."
                        style="height: 250px; width: 250px;" />
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <p class="card-text"><small class="text-muted">Posted by:
                                <?php echo $row['CreatedBy']?></small>
                        </p>
                        <h5 class="card-title"><?php echo $row['Title'] ?></h5>
                        <p class="card-text"><?php echo $row['Details'] ?></p>
                        <p class="card-text"><small class="text-muted"><?php echo $row['DateCreateds']?></small>
                        </p>
                        <br>
                        <hr>
                        <!-- <a href="index.php?view=officialsedit&id=<?php echo $row['ID'] ?>"
                            class="btn btn-sm btn-outline-primary"><i class="bi-pencil"></i></a> -->

                        <a title="Delete" data-id="<?php echo $row['ID'] ?>" data-bs-toggle="modal"
                            data-bs-target="#delete_announcement" class="btn btn-sm btn-outline-danger passID"><i
                                class="bi-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
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


<?php 
function UploadImage(){
    $target_dir = "FR_FILES_BUDGET/";
    $target_file = $target_dir  . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
    
    // if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
    //     || $imageFileType != "gif" || $imageFileType != "docs" || $imageFileType != "mp4") {
         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            return   basename($_FILES["fileToUpload"]["name"]);
        }else{
          //  echo "Error Uploading File";
            exit;
        }
    // }else{//
    //        // echo "File Not Supported";
    //         exit;
//}
} 


if(isset($_POST["btnSubmit"]))
{
    $FR = New Announcement();
    $id = $_POST['idkl'];
    $FR->delete( $id);
    
    // echo '<script>alert("Account Created!")</script>';
    // redirect("index.php?q=userlist");

    echo '<script type="text/javascript">
    swal({
        title: "Record Deleted!",
        text: "Record has been deleted.",
        type: "info",
        showConfirmButton: false,
        timer: 2500
    },  function () {
        window.location.href = "index.php?view=announcementlist";
    });
    </script>';
}
?>

<script>
$(document).on("click", ".passID", function() {
    var itemid = $(this).data('id');
    $("#idkl").val(itemid);
    $('#delete_newflash').modal('show');
});




$("document").ready(function() {


    $("#filterTable").dataTable({
        "searching": true
    });

    //     //Get a reference to the new datatable
    //     var table = $('#filterTable').DataTable();

    //     //Take the category filter drop down and append it to the datatables_filter div. 
    //     //You can use this same idea to move the filter anywhere withing the datatable that you want.
    //     $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));

    //     //Get the column index for the Category column to be used in the method below ($.fn.dataTable.ext.search.push)
    //     //This tells datatables what column to filter on when a user selects a value from the dropdown.
    //     //It's important that the text used here (Category) is the same for used in the header of the column to filter
    //     var categoryIndex = 0;
    //     $("#filterTable th").each(function(i) {
    //         if ($($(this)).html() == "Year") {
    //             categoryIndex = i;
    //             return false;
    //         }
    //     });

    //     //Use the built in datatables API to filter the existing rows by the Category column
    //     $.fn.dataTable.ext.search.push(
    //         function(settings, data, dataIndex) {
    //             var selectedItem = $('#categoryFilter').val()
    //             var category = data[categoryIndex];
    //             if (selectedItem === "" || category.includes(selectedItem)) {
    //                 return true;
    //             }
    //             return false;
    //         }
    //     );

    //     //Set the change event for the Category Filter dropdown to redraw the datatable each time
    //     //a user selects a new filter.
    //     $("#categoryFilter").change(function(e) {
    //         table.draw();
    //     });

    //     table.draw();
});
</script>