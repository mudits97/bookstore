<?php
    $target_dir = "material/";
    $target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    } else if($imageFileType!=="pdf" && $imageFileType!=="doc" && $imageFileType!=="docx" && $imageFileType!=="jpg") {
        echo "Invalid file format. Only doc,docx and pdf files are allowed.";
        $uploadOk=0;
        exit();
    }
    if($uploadOk) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            include 'session.php';
            session_start();
            $sql="insert into books(seller,name,author,price,pic,description,degree,branch,sem,type) values(".$_SESSION['user'].",'".$_POST['fileName']."','".$_SESSION['fullname']."',0,'".$_FILES["fileToUpload"]["name"]."','".$_POST["fileDescription"]."','".$_POST['degree']."','".$_POST['branch']."','".$_POST['semester']."','".$_POST['type']."')";
            $result = $conn->query($sql) or die("failed | ".$conn->error);
            if ($result === TRUE) {
                if($_SESSION['fullname']==="Admin") {
                    $sql="update books set allowed=1 where bid=".$conn->insert_id;
                    $result=$conn->query($sql) or die("error ".$conn->error);
                    if($result) {
                        header('Location: /dashboard.php?action=buy');
                    } else {
                        echo "failed";
                    }
                } else {
                    echo "index".$conn->insert_id;
                    $sql="insert into requests(bid,uid) values(".$conn->insert_id.",".$_SESSION['user'].")";
                    $result=$conn->query($sql);
                    if($result) {
                        header('Location: /dashboard.php?action=buy');
                    } else {
                        echo "Something went wrong.";
                    }
                }
            } else {
                echo "Something went wrong.";
            }
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "failed1";
    }
?>
