<?php
    include 'session.php';
    session_start();
    if(isset($_SESSION['user']) && isset($_POST['rid']) && isset($_POST['bid']) && isset($_POST['action']))  {
        if($_POST['action']==="accept") {
            $sql="update books set allowed=1 where bid=".$_POST['bid'];
            $result=$conn->query($sql) or die("error ".$conn->error);
            if($result) {
                echo "success";
            } else {
                echo "failed";
            }
        } else {
            $sql="delete from books where bid=".$_POST['bid'];
            $result=$conn->query($sql);
            if($result) {
                echo "success";
            } else {
                echo "failed";
            }
        }
        $sql="delete from requests where rid=".$_POST['rid'];
        $result=$conn->query($sql);
    }
    $conn->close();
?>
