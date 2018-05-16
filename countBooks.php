<?php
    include 'session.php';
    session_start();
    if(isset($_SESSION['user'])) {
        $sql1="select bid,uid from cart where uid=".$_SESSION['user'];
        $result1 = $conn->query($sql1);
        if($result1->num_rows>0) {
            echo $result1->num_rows;
        } else
            echo '0';
    }
    $conn->close()
?>
