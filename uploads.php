<?php
    $target_dir = "uploads/";
    $target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 750000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    } else if($imageFileType!=="png" && $imageFileType!=="jpg" && $imageFileType!=="jpeg") {
            echo "Invalid file format. Only png, jpg and jpeg are allowed";
    } else {

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        include 'session.php';
        session_start();
        $sql="insert into books(name,author,price,seller,pic,description,degree,branch,sem,type,allowed) values('".$_POST['bookName']."','".$_POST['bookAuthor']."',".intval($_POST['bookPrice']).",".$_SESSION['user'].",'".$_FILES["fileToUpload"]["name"]."','".$_POST['bookDescription']."','".$_POST['degree']."','".$_POST['branch']."','".$_POST['semester']."','book',0)";
        $result = $conn->query($sql) or die("failed | ".$conn->error);
        if ($result === TRUE) {
            header('Location: /dashboard.php?action=buy');
        } else {
            echo "Something went wrong.";
        }
        $conn->close();
    }
?>
