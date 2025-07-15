<?php
$id = 	$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayMongo Payment</title>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: linear-gradient(to right, rgb(63, 80, 156) 0%, rgb(130, 130, 148) 100%);
    }

    .container {
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        background-color: #fff;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    h2 {
        font-size: 30px;
        margin-bottom: 20px;
    }

    input {
        text-align: center;
        font-size: 20px;
        padding: 5px;
        border: none;
        border-bottom: 1px solid;
        outline: none;
    }

    button {
        font-size: 18px;
        padding: 7px;
        background-color: #16445e;
        border: none;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #16445e;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Complete Your Payment</h2>
        <form action="court_createpayment.php" method="POST">
            <label for="amount">Amount (PHP):</label>
            <input type="number" name="amount" value='100' readonly><br>
            <input type="hidden" name="id" value='<?php echo $id ?>' readonly><br>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>

</html>