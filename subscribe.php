<?php
    include 'session.php';
    session_start();
    if(isset($_POST['email'])) {
        $sql="insert into subscriptions(email) values('".$_POST['email']."')";
        $result=$conn->query($sql);
        if($result) {
            echo "success";
        } else {
            echo "already";
        }
    }
    $conn->close();
?>
