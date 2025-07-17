<?php
require_once("INCLUDE/initialize.php");
?>

<div class="container">
    <form method="post" class="text-center">
        <div class="row mt-3">
            <h4><span class="bi-person-plus"></span> <?php echo $title;?></h4>
            <hr>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="form-floating mb-2 text-start">
                    <input type="text" class="form-control" value="" name="Username" id="floatingInput"
                        placeholder="Username" required>
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-2 text-start">
                    <input type="text" class="form-control" value="" name="Fullname" id="Fullname"
                        placeholder="Fullname" required>
                    <label for="floatingInput">Fullname</label>
                </div>
                <div class="form-floating text-start mb-2">
                    <select class="form-select" name="UserType" id="UserType" aria-label=".form-select-sm example"
                        value="" required>
                        <option value="">Select User Type</option>
                        <?php
                                    $sql = "SELECT * FROM `usertype`";
                                    $mydb->setQuery($sql);
                                    $cur = $mydb->loadResultList();
                                    foreach ($cur as $res) {
                                    echo '<option value='.$res->UserType.'>'.$res->UserType.'</option>';
                                    }
                            ?>
                    </select>
                    <label for="floatingSelect">User Type</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-2 text-start">
                            <input type="password" class="form-control" value="" name="Password" id="Password"
                                placeholder="Password" required>
                            <label for="floatingInput">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-2 text-start">
                            <input type="password" class="form-control" value="" name="ConfirmPassword"
                                id="ConfirmPassword" placeholder="Confirm Password" required>
                            <label for="floatingInput">Confirm Password</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-2 text-start">
                    <div class="form-check ">
                        <input class="form-check-input" onclick="myFunction()" type="checkbox" value=""
                            id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Show Password
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>

        </div>
        <div class="row g-1 mb-1">
            <div class="col-12">
                <button type="submit" name="btnSubmit" class="btn btn-outline-success btn-sm "><span
                        class="bi-arrow-up-right-circle-fill"></span> Submit</button>
                <a href="index.php?view=userlist"><button type="button" class="btn btn-outline-danger btn-sm"><span
                            class="bi-x-circle-fill"></span> Cancel</button></a>
            </div>
        </div>
    </form>
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
</script>
<?php
if(isset($_POST["btnSubmit"]))
{
    $Users = new UserAccount();
    $Users->Username         = $_POST['Username'];
    $Users->Fullname         = $_POST['Fullname'];
    $Users->Password      = sha1($_POST['Password']);
    $Users->UserType         = $_POST['UserType'];
    $Users->create();

    // echo '<script>alert("Account Created!")</script>';
    // redirect("index.php?q=userlist");

    echo '<script type="text/javascript">
    swal({
        title: "Account Created!",
        text: "The user has been successfully registered",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    },  function () {
        window.location.href = "index.php?view=userlist";
    });
    </script>';
}

?>