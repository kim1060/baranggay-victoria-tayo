<?php
require_once("INCLUDE/initialize.php");
$_SESSION['attempt']=0;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// login confirmation
if (isset($_SESSION['UserID'])) {
  redirect(web_root . "index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="icon" type="image/x-icon" href="IMG/baranggay-victoria.png">
    <!-- Font Awesome -->
    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css" rel="stylesheet" />
    <!--SWEET ALERT -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <style>
    /* Override Bootstrap styles with simple, clean styling */
    .form-outline {
        margin-bottom: 20px !important;
    }

    .form-control, .form-select {
        border: 2px solid #e1e5e9 !important;
        border-radius: 8px !important;
        padding: 12px 15px !important;
        font-size: 16px !important;
        transition: all 0.3s ease !important;
        background: white !important;
        box-sizing: border-box !important;
    }

    .form-control:focus, .form-select:focus {
        outline: none !important;
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    }

    .form-control-lg, .form-select.form-control-lg {
        height: auto !important;
        padding: 12px 15px !important;
    }

    .form-label {
        display: block !important;
        margin-bottom: 8px !important;
        color: #555 !important;
        font-weight: 500 !important;
        font-size: 14px !important;
    }

    .form-label i {
        margin-right: 5px;
        color: #667eea;
    }

    /* Fieldset styling */
    fieldset {
        border: 1px solid #dee2e6 !important;
        border-radius: 8px !important;
        padding: 25px !important;
        margin-bottom: 25px !important;
        background: #f8f9fa !important;
    }

    legend {
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #495057 !important;
        padding: 0 10px !important;
        margin-bottom: 15px !important;
        width: auto !important;
        border-bottom: 2px solid #667eea !important;
        padding-bottom: 5px !important;
    }

    /* Row and column spacing */
    .row {
        margin-left: -10px !important;
        margin-right: -10px !important;
    }

    .col-md-4, .col-md-6 {
        padding-left: 10px !important;
        padding-right: 10px !important;
        margin-bottom: 10px !important;
    }

    /* Button styling */
    .btn {
        border-radius: 8px !important;
        font-weight: 600 !important;
        padding: 15px 24px !important;
        transition: all 0.3s ease !important;
        border: none !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: white !important;
        box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3) !important;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1ea085 100%) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4) !important;
        color: white !important;
    }

    /* Card styling */
    .card {
        border: none !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        border-radius: 15px !important;
    }

    .card-body {
        padding: 30px !important;
    }

    /* Password requirements */
    .password-requirements {
        margin-top: 10px !important;
        padding: 15px !important;
        background: #f8f9fa !important;
        border-radius: 8px !important;
        border: 1px solid #dee2e6 !important;
    }

    .password-requirements .requirement {
        margin: 5px 0 !important;
        font-size: 12px !important;
        transition: color 0.3s ease !important;
    }

    .password-requirements .requirement.valid {
        color: #28a745 !important;
        font-weight: 600 !important;
    }

    .password-requirements .requirement.invalid {
        color: #dc3545 !important;
    }

    /* Progress bar */
    .progress {
        height: 6px !important;
        border-radius: 3px !important;
        background-color: #e9ecef !important;
        margin: 10px 0 !important;
    }

    .progress-bar {
        border-radius: 3px !important;
        transition: width 0.3s ease !important;
    }

    /* Password match indicator */
    #match-text {
        font-size: 12px !important;
        font-weight: 500 !important;
        margin-top: 5px !important;
        display: block !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 20px !important;
        }

        fieldset {
            padding: 20px !important;
        }

        .col-md-4, .col-md-6 {
            margin-bottom: 15px !important;
        }
    }
    </style>
</head>

<body>
    <!-- Section: Design Block -->
    <!-- Registration Form -->
    <section class="vh-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-8">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                                        <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">Account
                                            Registration</h5>

                                        <!-- Personal Information Section -->
                                        <fieldset class="mb-4">
                                            <legend class="text-muted">Personal Information</legend>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Lastname"><i
                                                                class="bi bi-person"></i> Last Name</label>
                                                        <input type="text" id="Lastname" name="Lastname"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Firstname"><i
                                                                class="bi bi-person"></i> First Name</label>
                                                        <input type="text" id="Firstname" name="Firstname"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Middlename"><i
                                                                class="bi bi-person"></i> Middle Name</label>
                                                        <input type="text" id="Middlename" name="Middlename"
                                                            class="form-control form-control-lg" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Age"><i
                                                                class="bi bi-calendar"></i> Age</label>
                                                        <input type="number" id="Age" name="Age"
                                                            class="form-control form-control-lg" min="1" max="120" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Status"><i
                                                                class="bi bi-heart"></i> Civil Status</label>
                                                        <select class="form-select form-control-lg" id="Status" name="Status" required>
                                                            <option value="">Select Status</option>
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Divorced">Divorced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Citizenship"><i
                                                                class="bi bi-flag"></i> Citizenship</label>
                                                        <input type="text" id="Citizenship" name="Citizenship"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <!-- Contact Info Section -->
                                        <fieldset class="mb-4">
                                            <legend class="text-muted">Contact Info</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Email"><i
                                                                class="bi bi-envelope"></i> Email</label>
                                                        <input type="email" id="Email" name="Email"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Mobile"><i
                                                                class="bi bi-phone"></i> Mobile #</label>
                                                        <input type="tel" id="Mobile" name="Mobile"
                                                            class="form-control form-control-lg" maxlength="11"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <!-- Address Section -->
                                        <fieldset class="mb-4">
                                            <legend class="text-muted">Address</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Street">Street Address</label>
                                                        <input type="text" id="Street" name="Street"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Barangay">Barangay</label>
                                                        <input type="text" id="Barangay" name="Barangay"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="City">City/Municipality</label>
                                                        <input type="text" id="City" name="City"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="PostalCode">Postal Code</label>
                                                        <input type="number" id="PostalCode" name="PostalCode"
                                                            class="form-control form-control-lg" maxlength="4"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Hidden field to store concatenated address -->
                                            <input type="hidden" id="Address" name="Address" />
                                        </fieldset>

                                        <!-- Credentials Section -->
                                        <fieldset class="mb-4">
                                            <legend class="text-muted">Credentials</legend>
                                            <div class="form-outline">
                                                <label class="form-label" for="Username"><i
                                                        class="bi bi-person"></i> User Name</label>
                                                <input type="text" id="Username" name="Username"
                                                    class="form-control form-control-lg" required oninput="this.value = this.value.toUpperCase();" />
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="Password"><i
                                                                class="bi bi-lock"></i> Password</label>
                                                        <input type="password" id="Password" name="Password"
                                                            class="form-control form-control-lg" required minlength="8" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-outline">
                                                        <label class="form-label" for="ConfirmPassword"><i
                                                                class="bi bi-lock-fill"></i> Confirm Password</label>
                                                        <input type="password" id="ConfirmPassword" name="ConfirmPassword"
                                                            class="form-control form-control-lg" required />
                                                    </div>
                                                    <!-- Password Match Indicator -->
                                                    <small id="match-text" class="text-muted"></small>
                                                </div>
                                            </div>
                                            <div>
                                              <!-- Password Requirements -->
                                                    <div class="password-requirements w-100">
                                                        <div id="length" class="requirement invalid">At least 8
                                                            characters
                                                        </div>
                                                        <div id="uppercase" class="requirement invalid">At least one
                                                            uppercase letter
                                                        </div>
                                                        <div id="lowercase" class="requirement invalid">At least one
                                                            lowercase letter
                                                        </div>
                                                        <div id="number" class="requirement invalid">At least one
                                                            number
                                                        </div>
                                                        <div id="special" class="requirement invalid">At least one
                                                            special character (@$!%*?&)
                                                        </div>
                                                    </div>
                                                    <!-- Password Strength Bar -->
                                                    <div class="progress mt-2">
                                                        <div id="strength-bar" class="progress-bar" role="progressbar"
                                                            style="width: 0%;"></div>
                                                    </div>
                                                    <small id="strength-text" class="text-muted">Very Weak</small>
                                            </div>
                                        </fieldset>

                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button class="btn btn-success w-100" type="submit"
                                                name="btnRegister" id="btnRegister">
                                                <i class="bi bi-arrow-right-circle"></i> Next
                                            </button>
                                        </div>

                                        <a class="fw-bold text-success mt-3 d-block text-center" href="login.php">Log in
                                            here!</a>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js"
        integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>

    <script>
    function ShowPass() {
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

    // Function to capitalize input values
    function capitalizeInput(event) {
        event.target.value = event.target.value.toUpperCase();
    }

    // Password validation function
    function validatePassword() {
        const password = document.getElementById('Password').value;
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /\d/.test(password),
            special: /[@$!%*?&]/.test(password)
        };

        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(req);
            if (element) {
                element.className = requirements[req] ? 'requirement valid' : 'requirement invalid';
            }
        });

        // Calculate password strength
        const validRequirements = Object.values(requirements).filter(req => req).length;
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        if (strengthBar && strengthText) {
            let strength = 0;
            let strengthLabel = 'Very Weak';
            let strengthColor = '#dc3545';

            if (validRequirements >= 5) {
                strength = 100;
                strengthLabel = 'Strong';
                strengthColor = '#28a745';
            } else if (validRequirements >= 4) {
                strength = 80;
                strengthLabel = 'Good';
                strengthColor = '#ffc107';
            } else if (validRequirements >= 3) {
                strength = 60;
                strengthLabel = 'Fair';
                strengthColor = '#fd7e14';
            } else if (validRequirements >= 2) {
                strength = 40;
                strengthLabel = 'Weak';
                strengthColor = '#dc3545';
            }

            strengthBar.style.width = strength + '%';
            strengthBar.style.backgroundColor = strengthColor;
            strengthText.textContent = strengthLabel;
            strengthText.style.color = strengthColor;
        }

        return Object.values(requirements).every(req => req);
    }

    // Enhanced password matching validation
    function validatePasswordMatch() {
        const password = document.getElementById('Password').value;
        const confirmPassword = document.getElementById('ConfirmPassword').value;
        const confirmField = document.getElementById('ConfirmPassword');
        const matchText = document.getElementById('match-text');

        if (!confirmPassword) {
            if (matchText) {
                matchText.textContent = 'Enter password above first';
                matchText.style.color = '#6c757d';
            }
            confirmField.setCustomValidity('');
            confirmField.style.borderColor = '#ced4da';
            return;
        }

        if (password !== confirmPassword) {
            confirmField.setCustomValidity('Passwords do not match');
            confirmField.style.borderColor = '#dc3545';
            if (matchText) {
                matchText.textContent = '✗ Passwords do not match';
                matchText.style.color = '#dc3545';
            }
        } else {
            confirmField.setCustomValidity('');
            confirmField.style.borderColor = '#28a745';
            if (matchText) {
                matchText.textContent = '✓ Passwords match';
                matchText.style.color = '#28a745';
            }
        }
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

    // Add event listener to form submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[method="post"]');
        if (form) {
            form.addEventListener('submit', function(e) {
                concatenateAddress();
            });
        }

        // Update address when fields change
        ['Street', 'Barangay', 'City', 'PostalCode'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', concatenateAddress);
            }
        });
    });

    // Attach the capitalizeInput function to relevant input fields
    document.addEventListener('DOMContentLoaded', function() {
        const fieldsToCapitalize = ['Lastname', 'Firstname', 'Middlename', 'Street', 'Barangay', 'City', 'Citizenship'];
        fieldsToCapitalize.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', capitalizeInput);
            }
        });

        // Add password validation event listeners
        const passwordField = document.getElementById('Password');
        const confirmPasswordField = document.getElementById('ConfirmPassword');
        const form = document.querySelector('form[method="post"]');

        if (passwordField) {
            passwordField.addEventListener('input', validatePassword);
            passwordField.addEventListener('keyup', validatePassword);
        }

        if (confirmPasswordField) {
            confirmPasswordField.addEventListener('input', validatePasswordMatch);
            confirmPasswordField.addEventListener('keyup', validatePasswordMatch);
        }

        // Enhanced form submission validation
        if (form) {
            form.addEventListener('submit', function(e) {
                const isPasswordValid = validatePassword();
                const password = document.getElementById('Password').value;
                const confirmPassword = document.getElementById('ConfirmPassword').value;

                if (!isPasswordValid) {
                    e.preventDefault();
                    swal({
                        title: "Invalid Password!",
                        text: "Password must meet all security requirements.",
                        type: "error",
                        showConfirmButton: true
                    });
                    return false;
                }

                if (password !== confirmPassword) {
                    e.preventDefault();
                    swal({
                        title: "Password Mismatch!",
                        text: "Passwords do not match. Please check and try again.",
                        type: "error",
                        showConfirmButton: true
                    });
                    return false;
                }

                // If validation passes, concatenate address
                concatenateAddress();
                return true;
            });
        }

        // Initial validation on page load
        validatePassword();
    });
    </script>
</body>

</html>

<?php



  if (isset($_POST['btnRegister'])) {
    $Mobile = $_POST['Mobile'];
    $Email = $_POST['Email'];
    $Lastname         = $_POST['Lastname'];
    $Firstname         = $_POST['Firstname'];
    $Middlename       = $_POST['Middlename'];
    $Address          = $_POST['Address'];
    $Age              = $_POST['Age'];
    $Status           = $_POST['Status'];
    $Citizenship      = $_POST['Citizenship'];

    // $file_name = $_FILES['image']['name'];
    // $file_tmp =$_FILES['image']['tmp_name'];
    // move_uploaded_file($file_tmp,"IMG/".$file_name);
    // //echo '<img src="IMG/'.$file_name.'" style="width:100%">';
    // shell_exec('"C:\\Program Files\\Tesseract-OCR\\tesseract" "C:\\xampp\\htdocs\\Appointmate\\IMG\\'.$file_name.'" out');

    // $myfile = fopen("out.txt", "r") or die("Unable to open file!");
    // $laman = fread($myfile,filesize("out.txt"));

    // echo fread($myfile,filesize("out.txt"));



  //echo str_replace(" ","",$Address);
//   $finaladd=str_replace(" ","",$Address);
//  $f=str_replace(",","",$finaladd);
//  echo str_replace(".","",$f);

//   $finallaman=str_replace(" ","",$laman);
//  $l=str_replace(",","",$finallaman);

//  $ff=str_replace(".","",$f);
// $ll=str_replace(".","",$l);

// if (str_contains($ll, $ff)) {
//     echo "Substring found!";
// } else {
//     echo "Substring not found.";
// }

//     echo " <input type='text' value='$ll'>";

//     fclose($myfile);


    if ($_POST['Password'] !== $_POST['ConfirmPassword']) {
      echo '
      <script type="text/javascript">
       swal({
          title: "Password not match!",
          text: "Please check your Password.",
          type: "warning",
          showConfirmButton: false,
          timer: 2500
      });
      </script>
      ';
    }

    else {


            $Users = New UserAccount();
            $Users->Lastname         = $_POST['Lastname'];
            $Users->Firstname         = $_POST['Firstname'];
            $Users->Middlename         = $_POST['Middlename'];
            $Users->Address         = $_POST['Address'];
            $Users->Age         = $_POST['Age'];
            $Users->Status         = $_POST['Status'];
            $Users->Citizenship         = $_POST['Citizenship'];
            $Users->Email         = $_POST['Email'];
            $Users->Contact         = $_POST['Mobile'];
            $Users->Username         = $_POST['Username'];
            $Users->Password      = sha1($_POST['Password']);
            $Users->Laman      = ""; // Default empty value for Laman field
            $Users->UserType      = "USER";
            $Users->VerCode      = "";
            $Users->IsVerified      = "0";
            $Users->create();


            echo '
            <script type="text/javascript">
             swal({
                title: "Account Created!",
                text: "Will send you an Email for verification code. Please login and verify your account.",
                type: "success",
              showConfirmButton: true
          },  function () {
              window.location.href = "login.php";
          });
          </script>';

           $Code = rand(123654,987456);

           $sql = "SELECT MAX(UserID) as lastid from user_account";
           $mydb->setQuery($sql);
           $cur = $mydb->loadResultList();
           foreach ($cur as $result) {
           $lastid=$result->lastid;
           }

          $sql = "UPDATE user_account SET VerCode='$Code' WHERE UserID='$lastid'";
          $mydb->setQuery($sql);
          $mydb->executeQuery();





              // $ch = curl_init();
              // $parameters = array(
              //         'apikey' => '06f202f323dc165c1809c5310e339a17',
              //         'number' =>  $Mobile,
              //         'message' => 'DMW: Good day '.$Firstname.' '.$Lastname.' ! Your registration verification code is '.$Code.'. Thank you!',
              //         'sendername' => 'SEMAPHORE'
              //         );
              //         curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
              //         curl_setopt( $ch, CURLOPT_POST, 1 );
              //         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
              //         curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
              //         $result = curl_exec($ch);
              //         curl_close($ch);

          require 'PHPMailer/src/Exception.php';
          require 'PHPMailer/src/PHPMailer.php';
          require 'PHPMailer/src/SMTP.php';
          $mail = new PHPMailer(true);
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'thesiswebsite2024@gmail.com';
          $mail->Password = 'ylku vutf rqsi jzfy';
          $mail->SMTPSecured = 'tls';
          $mail->Port = 587;
          $mail->setFrom('thesiswebsite2024@gmail.com');
          $mail->addAddress($Email);
          $mail->isHTML(true);
          $mail->Subject='SYSTEM NOTIFICATION: VERIFICATION CODE';
          $mail->Body='<HTML>Good day '.$Firstname.' '.$Lastname.' ! Your registration verification code is <strong>'.$Code.'</strong>. Login got to My Account and verify. Thank you!</HTML>';
          $mail->send();
        }

    }


  ?>