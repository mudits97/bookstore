<?php
    include 'session.php';
    session_start();
    if(!isset($_SESSION['user'])) {
        if(isset($_POST['email']) && isset($_POST['fullname']) && isset($_POST['password']) && isset($_POST['phone']) && isset($_POST['type'])) {
            if($_POST['type']==="login") {
                if (preg_match("/^[a-zA-Z0-9]{8,}$/",$_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $sql="select id,fullname,password,email,phone,address from users where email='".$_POST['email']."' and password='".$_POST['password']."'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $_SESSION['user']=$row['id'];
                            $_SESSION['email']=$row['email'];
                            $_SESSION['fullname']=$row['fullname'];
                            $_SESSION['phone']=$row['phone'];
                            $_SESSION['address']=$row['address'];
                            header('Location: /');
                        }
                    } else
                        header('Location: /?redirect=login');
                    $conn->close();
                } else {
                    header('Location: /?redirect=login');
                }
            } else {
                if (preg_match("/^[a-zA-Z0-9]{8,}$/",$_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && preg_match("/^[0-9]{10}$/",$_POST['phone']) && preg_match("/^[a-zA-Z ]+$/",$_POST['fullname'])) {
                    $sql="insert into users(email,password,fullname,phone) values('".$_POST['email']."','".$_POST['password']."','".$_POST['fullname']."',".$_POST['phone'].")";
                    $result = $conn->query($sql) or die("failed ".$conn->error);
                    echo "RESULT: ".$result.'\n';
                    if ($result === TRUE) {
                        $sql="select id,fullname,password,email,phone,address from users where email='".$_POST['email']."' and password='".$_POST['password']."'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $_SESSION['user']=$row['id'];
                                $_SESSION['email']=$row['email'];
                                $_SESSION['fullname']=$row['fullname'];
                                $_SESSION['phone']=$row['phone'];
                                $_SESSION['address']=$row['address'];
                                header('Location: /');
                            }
                        }
                    } else
                        header('Location: /?redirect=login');
                    $conn->close();
                } else {
                    header('Location: /?redirect=login');
                }
            }
        } else {
            header('Location: /?redirect=login');
        }
    } else {
        header('Location: /redirect=login');
    }
?>
