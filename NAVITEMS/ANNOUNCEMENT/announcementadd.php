<?php
require_once("INCLUDE/initialize.php");
?>

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />

    <style>
    #image-preview {
        width: 300px;
        /* Fixed width */
        height: 300px;
        /* Fixed height */
        border: 1px solid #ccc;
        margin: auto;
        overflow: hidden;
        /* To ensure the image does not overflow */
    }

    #image-preview img {
        width: 300px;
        height: 300px;
        object-fit: contain;
    }
    </style>
</head>
<div class="container">
    <form method="post" class="text-center" enctype="multipart/form-data" autocomplete="off">
        <div class="row mt-3">
            <h4><span class="bi-journal-plus"></span> <?php echo $title;?></h4>
            <hr>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="text-center mb-2">
                    <div id="image-preview"></div>
                </div>
                <div class="form-floating mb-2 text-start">
                    <input type="file" id="image-input" name="image" accept="image/*" onchange="previewImage()"
                        required />
                </div>

                <div class="form-floating mb-2 text-start">
                    <input type="text" class="form-control" value="" name="Title" id="floatingInput" placeholder="Title"
                        required>
                    <label for="floatingInput">Title</label>
                </div>


                <div class="form-floating mb-2 text-start">
                    <textarea class="form-control" placeholder="Details" name="Details" id="floatingTextarea"
                        required></textarea>
                    <label for="floatingTextarea">Details</label>
                </div>



            </div>
            <div class="col-md-4">
            </div>

        </div>
        <div class="row g-1 mb-1">
            <div class="col-12">
                <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Submit</button>
                <a href="index.php?view=officialslist"><button type="button" class="btn btn-outline-danger btn-sm"><span
                            class="bi-x-circle-fill"></span> Cancel</button></a>
            </div>
        </div>
    </form>
</div>
<script>
function previewImage() {
    var fileInput = document.getElementById("image-input");
    var imagePreview = document.getElementById("image-preview");

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.innerHTML =
                '<img src="' + e.target.result + '" alt="Preview">';
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}
</script>
<?php

function UploadImage(){

    $target_dir = "NEWS_IMAGE/";
    $target_file = $target_dir  . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


    // if($imageFileType != "jpg" || $imageFileType != "png" || $imageFileType != "jpeg"
    //     || $imageFileType != "gif" || $imageFileType != "docs" || $imageFileType != "mp4") {
         if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            return   basename($_FILES["image"]["name"]);
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
    $date = date('Y-m-d H:i:s');
    $FR = new Announcement();
    $FR->Title         = $_POST['Title'];
    $FR->Details         = $_POST['Details'];
    $FR->Filename      = UploadImage();
    $FR->DateCreated      =  $date ;
    $FR->CreatedBy      =  $_SESSION['Username'] ;
    $FR->create();

    // echo '<script>alert("Account Created!")</script>';
    // redirect("index.php?q=userlist");

    echo '<script type="text/javascript">
    swal({
        title: "Success!",
        text: "Record successfully created.",
        type: "success",
        showConfirmButton: false,
        timer: 2500
    },  function () {
        window.location.href = "index.php?view=announcementlist";
    });
    </script>';
}

?>