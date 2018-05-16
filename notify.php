<?php
    include 'session.php';
    session_start();
    if(isset($_SESSION['user']) && isset($_REQUEST['msg']) && isset($_REQUEST['id']) && isset($_REQUEST['action'])) {
        if($_REQUEST['action']==="accept") {
            $sql="update cart set status=1 where cid=".$_REQUEST['id'];
            $result=$conn->query($sql);
            if($result) {
                $sql="insert into notifications(msg,uid) values('".$_REQUEST['msg']."',".$_REQUEST['uid'].")";
                $result=$conn->query($sql);
                if($result) {
                    echo "success";
                } else {
                    echo "failed";
                }
            } else {
                echo "failed";
            }
        } else {
            $sql="delete from cart where cid=".$_REQUEST['id'];
            $result=$conn->query($sql);
            if($result) {
                $sql="insert into notifications(msg,uid) values('".$_REQUEST['msg']."',".$_REQUEST['uid'].")";
                $result=$conn->query($sql);
                if($result) {
                    echo "success";
                } else {
                    echo "failed";
                }
            } else {
                echo "failed";
            }
        }
    }
?>
