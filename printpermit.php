<?php
require_once("INCLUDE/initialize.php");
$id = $_POST['id'];

$AppDate="";
//TRANSACTION DETAILS
$MyClass = New _permit();
$res = $MyClass->single_data($id);

$ID = $res->ID;
$UserID=$res->UserID;
$DocStatus=$res->Status;
$AppointmentDate=$res->AppointmentDate;
$dd = strtotime($AppointmentDate);
$Comment = $res->Comment;

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

//DATE
$sql = "SELECT DATE_FORMAT(NOW(),'%W, %b %d, %Y' ) as IssuedDate";
$mydb->setQuery($sql);
$cur = $mydb->loadResultList();
foreach ($cur as $result)
{
    $IssuedDate = $result->IssuedDate;
}


// $query = "SELECT UserID, COUNT(*) as TOTALRESPONDENTS FROM surveysubmit WHERE Category='$Category' GROUP BY UserID";
// $mydb->setQuery($query);
// $row = $mydb->executeQuery();
// $TOTALRESPONDENTS = $mydb->num_rows($row);


?>
<!DOCTYPE html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Business Permit</title>
    <link rel="icon" type="image/x-icon" href="IMG/APP_LOGO.PNG">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
    p {
        text-indent: 50px;
    }

    .pb {
        padding-right: 60px;
    }
    </style>

</head>


<!-- <body> -->

<body onload="window.print();">
    <br>

    <div class="container">
        <div class="text-center">
            <h5>Republic of the Philippines</h5>
            <h5>BARANGAY VICTORIA REYES</h5>
            <h5> Dasmariñas, Cavite</h5>
            <br>
            <h3>BUSINESS PERMIT</h3>
        </div>
        <br>
        <br>
        <div class="text-start">

            <div class="row">
                <div class="col-md-3">
                    <strong>
                        Proprietor:
                    </strong> <?php echo $Firstname .' '.$Middlename.', '.$Lastname?>
                </div>

                <div class="col-md-6">
                    <strong>
                        Address:
                    </strong> &nbsp&nbsp&nbsp&nbsp<?php echo ''.$Address?></strong>
                </div>
            </div>
            <br>

            <p>
                This Permit is being issued subject to existing rules and regulations, provided however, that the
                necessary fees are paid to the Treasurer of the Barangay as assessed.
            </p>

            <p>
                This is non-transferable and shall be deemed null and void upon failure by the owner to follow the said
                rules and regulations set forth by the Local Government Unit of Dasmariñas, Cavite

            </p>


            <p>
                Given this <?php echo $IssuedDate?> at Barangay Victoria Reyes, Dasmariñas, Cavite.
            </p>
            <br>
            <br>
            <div class="text-end mt-4">
                <strong>HON. LEONILA " VAL " C. BUCAO</strong>
                <div class="pb">
                    Punong Barangay
                </div>

            </div>
            <!-- <br>
            <div class="text-start mt-4">
                Specimen Signature of Applicant:
                <br>
                ____________________________________
            </div> -->

        </div>
    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>