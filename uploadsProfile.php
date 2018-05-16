<?php
    session_start();
    if(isset($_SESSION['user']) && isset($_POST['userName']) && isset($_POST['userAddress']) && isset($_POST['userPhone'])) {
        include 'session.php';
        $target_dir = "profile/";
        $target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_file = $target_dir .$_SESSION['user'].'.jpg';
		if(isset($_POST["submit"]) && $_FILES["fileToUpload"]["tmp_name"]!=="") {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 750000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.".$imageFileType;
				$uploadOk = 0;
			}
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
        }
        if($uploadOk) {
            $sql="update users set fullName='".$_POST['userName']."',phone=".$_POST['userPhone'].",address='".$_POST['userAddress']."' where id=".$_SESSION['user'];
            $result = $conn->query($sql) or die("failed | ".$conn->error);
            if ($result === TRUE) {
                $_SESSION['fullname']=$_POST['userName'];
                $_SESSION['address']=$_POST['userAddress'];
                $_SESSION['phone']=$_POST['userPhone'];
                header('Location: /dashboard.php?action=buy');
            } else {
                echo "Something went wrong.";
            }
        }
        $conn->close();
    }
?>
