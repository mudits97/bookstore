<?php
    include 'session.php';
    session_start();
    if(isset($_SESSION['user'])) {
        $sql1="select bid,uid from cart where bid=".$_POST['bid']." and uid=".$_SESSION['user'];
        $result1 = $conn->query($sql1);
        if ($result1->num_rows === 0) {
            $sql="insert into cart(uid,bid) values(".$_SESSION['user'].",".$_POST['bid'].")";
            $result = $conn->query($sql) or die("failed | ".$conn->error);
            if ($result === TRUE) {
                echo "added";
            } else {
                echo "failed";
            }
        } else {
            $sql1="delete from cart where bid=".$_POST['bid']." and uid=".$_SESSION['user'];
            $result1 = $conn->query($sql1);
            if ($result1) {
                echo "removed";
            } else {
                echo "failed";
            }
        }
    } else {
        echo "notloggedin";
    }
    $conn->close();
?>
