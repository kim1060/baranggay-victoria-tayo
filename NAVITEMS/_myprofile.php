<?php
require_once("INCLUDE/initialize.php");
$id = 	$_SESSION['UserID'];
$MyClass = New UserAccount();
$res = $MyClass->single_data($id);

$UserID = $res->UserID;
$Lastname = $res->Lastname;
$Firstname = $res->Firstname;
$Middlename = $res->Middlename;
$Address = $res->Address;
$Age = $res->Age;
$Status = $res->Status;
$Citizenship = $res->Citizenship;
$Email = $res->Email;
$Contact = $res->Contact;

$Username = $res->Username;
$Password = $res->Password;
$Filename = $res->Filename;

// Parse address into components - handle both old (pipe) and new (comma) formats
$Street = '';
$Barangay = '';
$City = '';
$PostalCode = '';

if (!empty($Address)) {
    // Try comma format first (new format)
    if (strpos($Address, ',') !== false) {
        $addressParts = array_map('trim', explode(',', $Address));
        $Street = isset($addressParts[0]) ? $addressParts[0] : '';
        $Barangay = isset($addressParts[1]) ? $addressParts[1] : '';
        $City = isset($addressParts[2]) ? $addressParts[2] : '';
        $PostalCode = isset($addressParts[3]) ? $addressParts[3] : '';
    }
    // Try pipe format (old format)
    elseif (strpos($Address, '|') !== false) {
        $addressParts = explode('|', $Address);
        $Street = isset($addressParts[0]) ? $addressParts[0] : '';
        $Barangay = isset($addressParts[1]) ? $addressParts[1] : '';
        $City = isset($addressParts[2]) ? $addressParts[2] : '';
        $PostalCode = isset($addressParts[3]) ? $addressParts[3] : '';
    }
    // If no separators found, put everything in Street
    else {
        $Street = $Address;
        $Barangay = '';
        $City = '';
        $PostalCode = '';
    }
}
?>

<div class="container mb-5">
    <h4 class="text-center"><span class="bi-person-lines-fill"></span> <?php echo $title;?> <span
            class="text-primary">(Verified)</span>
    </h4>
    <hr>

    <div class="row mt-3">
        <div class="row">
            <div class="col-md-4">

                <img src="./IMG/<?php echo $Filename ?>" class="img-fluid rounded-start img-1 border border-dark"
                    alt="..." style="height: 250px; width: 100%;" />

            </div>
            <div class="col-md-8">
                <form method="post">
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
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Street ?>" name="Street"
                                    id="Street" placeholder="Street Address" required>
                                <label for="floatingInput">Street Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $Barangay ?>" name="Barangay"
                                    id="Barangay" placeholder="Barangay" required>
                                <label for="floatingInput">Barangay</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $City ?>" name="City"
                                    id="City" placeholder="City/Municipality" required>
                                <label for="floatingInput">City/Municipality</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-2 text-start">
                                <input type="text" class="form-control" value="<?php echo $PostalCode ?>" name="PostalCode"
                                    id="PostalCode" placeholder="Postal Code" maxlength="4"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                <label for="floatingInput">Postal Code</label>
                            </div>
                        </div>
                    </div>
                    <!-- Hidden field to store concatenated address -->
                    <input type="hidden" id="Address" name="Address" value="<?php echo $Address ?>" />

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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
<input type="text" class="form-control" value="<?php echo $Username ?>" name="Username"
    id="floatingInput" placeholder="Username" required oninput="this.value = this.value.toUpperCase();">
                                <label for="floatingInput">Username</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
                                <input type="password" class="form-control" value="" name="Password" id="Password"
                                    placeholder="Password">
                                <label for="floatingInput">Password</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-2 text-start">
                                <input type="password" class="form-control" value="" name="ConfirmPassword"
                                    id="ConfirmPassword" placeholder="Confirm Password">
                                <label for="floatingInput">Confirm Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-success" role="alert">
                        * If you don't want to change password, leave it blank.
                    </div>
                    <div class="row g-1 mb-1 text-center">
                        <div class="col-12">
                            <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                                    class="bi-arrow-up-right-circle-fill"></span> Submit</button>
                            <a href="index.php?view=X"><button type="button" class="btn btn-outline-danger btn-sm"><span
                                        class="bi-x-circle-fill"></span> Cancel</button></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
function myFunction() {
    var x = document.getElementById("Password");
    var y = document.getElementById("ConfirmPassword");
    if (x.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
}

function onlyNumberKey(evt) {
    // Only ASCII character in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function handleSelectChange(event) {
    var selectElement = event.target;
    var value = selectElement.value;
    var selectedText = selectElement.options[selectElement.selectedIndex].text;
    //alert(selectedText);
    document.getElementsByName('Questions')[0].value = selectedText;
}

function concatenateAddress() {
    const street = document.getElementById('Street').value;
    const barangay = document.getElementById('Barangay').value;
    const city = document.getElementById('City').value;
    const postalCode = document.getElementById('PostalCode').value;

    // Concatenate with commas as requested
    const fullAddress = `${street}, ${barangay}, ${city}, ${postalCode}`;
    document.getElementById('Address').value = fullAddress;
}

// Initialize address concatenation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[method="post"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            concatenateAddress();
        });
    }

    // Also update address when fields change
    ['Street', 'Barangay', 'City', 'PostalCode'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', concatenateAddress);
        }
    });

    // Initial concatenation on page load
    concatenateAddress();
});
</script>
<?php
if(isset($_POST["btnSubmit"]))
{
    if($_POST['Password']!=$_POST['ConfirmPassword']) {
        echo '<script type="text/javascript">
        swal({
            title: "Password not match",
            text: "The provided information are invalid",
            type: "info",
            showConfirmButton: false,
            timer: 2500
        },  function () {
        });
        </script>';
    }
    else {
    if($_POST['Password'] == "")
    {
        $Users = new UserAccount();
        $Users->Lastname         = $_POST['Lastname'];
        $Users->Firstname         = $_POST['Firstname'];
        $Users->Middlename         = $_POST['Middlename'];
        $Users->Address         = $_POST['Address'];
        $Users->Age         = $_POST['Age'];
        $Users->Status         = $_POST['Status'];
        $Users->Citizenship         = $_POST['Citizenship'];
        $Users->Email         = $_POST['Email'];
        $Users->Contact         = $_POST['Contact'];
        $Users->Username         = $_POST['Username'];
        // $Users->Password      = sha1($_POST['Password']);
        // $Users->UserType      = "USER";
        // $Users->VerCode      = "123";
        // $Users->IsVerified      = "0";
        $Users->update($UserID);


        echo '<script type="text/javascript">
        swal({
            title: "Account Updated!",
            text: "Your account has been successfully updated",
            type: "success",
            showConfirmButton: false,
            timer: 2500
        },  function () {
            window.location.href = "index.php?view=home";
        });
        </script>';
    }
    else
    {
        $Users = new UserAccount();
        $Users->Lastname         = $_POST['Lastname'];
        $Users->Firstname         = $_POST['Firstname'];
        $Users->Middlename         = $_POST['Middlename'];
        $Users->Address         = $_POST['Address'];
        $Users->Age         = $_POST['Age'];
        $Users->Status         = $_POST['Status'];
        $Users->Citizenship         = $_POST['Citizenship'];
        $Users->Email         = $_POST['Email'];
        $Users->Contact         = $_POST['Contact'];
        $Users->Username         = $_POST['Username'];
       $Users->Password      = sha1($_POST['Password']);
        // $Users->UserType      = "USER";
        // $Users->VerCode      = "123";
        // $Users->IsVerified      = "0";
        $Users->update($UserID);


        echo '<script type="text/javascript">
        swal({
            title: "Account Updated!",
            text: "Your account has been successfully updated",
            type: "success",
            showConfirmButton: false,
            timer: 2500
        },  function () {
            window.location.href = "index.php?view=home";
        });
        </script>';
    }
    }
}
?>