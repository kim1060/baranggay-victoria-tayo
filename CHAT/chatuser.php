<?php
session_start();
include('db.php');

$username = $_SESSION['Username'];
$selectedUser = '';



if (isset($_GET['user'])) {
    $selectedUser = $_GET['user'];
    $selectedUser    = mysqli_real_escape_string($conn, $selectedUser);
    $showChatBox = true; // Set to true only when a user is selected
} else {
    $showChatBox = false; // Set to false initially
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPOINTMATE - MESSAGES</title>
    <link rel="icon" type="image/x-icon" href="IMG/baranggay-victoria.png">
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Welcome, <?php echo ucfirst($username); ?>!</h2>
        </div>
        <div class="account-info">
            <div class="user-list">
                <h2>Select a User to Chat With: New Message</h2>
                <ul>

                    <?php

            $qry1 = mysqli_query($conn, "SELECT sender, count(`read`) as Meron FROM chat_messages where receiver='$username' and `read`=0 group by receiver,sender");
            while ($row = $qry1->fetch_assoc()) :
                $bilang = $row['Meron'];
                $user = $row['sender'];
             ?>

                    <li><a href='chatuser.php?user=<?php echo $user ?>'><?php echo $user ?> (<?php echo $bilang ?> - New
                            Message)</a></li>

                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <div class="account-info">
            <div class="user-list">
                <h2>Message History</h2>
                <ul>
                    <?php

          $qry1 = mysqli_query($conn, "SELECT sender, count(`read`) as Meron FROM chat_messages where receiver='$username' and `read`=1 group by receiver,sender");
          while ($row = $qry1->fetch_assoc()) :
              $bilang = $row['Meron'];
              $user = $row['sender'];
             ?>

                    <li><a href='chatuser.php?user=<?php echo $user ?>'><?php echo $user ?> </a></li>

                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <?php if ($showChatBox): ?>
        <div class="chat-box" id="chat-box">
            <div class="chat-box-header">
                <h2><?php echo ucfirst($selectedUser); ?></h2>
                <button class="close-btn" onclick="closeChat()">✖</button>
            </div>
            <div class="chat-box-body" id="chat-box-body">
                <!-- Chat messages will be loaded here -->
            </div>
            <form class="chat-form" id="chat-form">
                <input type="hidden" id="sender" value="<?php echo $username; ?>">
                <input type="hidden" id="receiver" value="<?php echo $selectedUser; ?>">
                <input type="text" id="message" placeholder="Type your message..." required>
                <button class="text-end" type="submit">Send</button>
            </form>
        </div>
    </div>
    <?php endif; ?>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    function closeChat() {
        document.getElementById("chat-box").style.display = "none";
    }


    // Function to toggle chat box visibility
    function toggleChatBox() {
        var chatBox = document.getElementById("chat-box");
        if (chatBox.style.display === "none") {
            chatBox.style.display = "block"; // Show the chat box
        } else {
            chatBox.style.display = "none"; // Hide the chat box
        }
    }


    function fetchMessages() {
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();

        $.ajax({
            url: 'fetch_messages.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver
            },
            success: function(data) {
                $('#chat-box-body').html(data);
                scrollChatToBottom();
            }
        });
    }


    // Function to scroll the chat box to the bottom
    function scrollChatToBottom() {
        var chatBox = $('#chat-box-body');
        chatBox.scrollTop(chatBox.prop("scrollHeight"));
    }



    $(document).ready(function() {
        // Fetch messages every 3 seconds

        fetchMessages();
        setInterval(fetchMessages, 3000);
    });


    // Submit the chat message
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();
        var message = $('#message').val();

        $.ajax({
            url: 'submit_message.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver,
                message: message
            },
            success: function() {
                $('#message').val('');
                fetchMessages(); // Fetch messages after submitting
            }
        });

    });
    </script>



</html>
</body>

</html>