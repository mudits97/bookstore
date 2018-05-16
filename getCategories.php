<?php
    include 'session.php';
    session_start();
    $degreeFilter=$branchFilter=$semesterFilter="%";
    if($_REQUEST['degree']!=="None") {
        $degreeFilter=$_REQUEST['degree'];
    }
    if($_REQUEST['branch']!=="None") {
        $branchFilter=$_REQUEST['branch'];
    }
    if($_REQUEST['semester']!=="None") {
        $semesterFilter=$_REQUEST['semester'];
    }

    if($_REQUEST['type']==="book")
        $sql="SELECT allowed,bid,name,author,price,seller,pic,description,fullname,email,phone FROM `books` as b,users as u  WHERE seller=id and degree like  '".$degreeFilter."' and branch like '".$branchFilter."' and sem like '".$semesterFilter."' and type='".$_REQUEST['type']."'";
    else
        $sql="SELECT allowed,bid,name,author,price,seller,pic,description,fullname,email,phone FROM `books` as b,users as u  WHERE seller=id and degree like  '".$degreeFilter."' and branch like '".$branchFilter."' and sem like '".$semesterFilter."' and type='".$_REQUEST['type']."' and allowed=1";
    $result=$conn->query($sql);
    if($result->num_rows>0) {
        while($row=$result->fetch_assoc()) {
            if($_POST['type']==="book")
                echo '<li class=\'book-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>Rs. '.$row['price'].'</p><button id="addToCart" bookid="'.$row['bid'].'">Add to cart</button></div></div></li>';
            else {
                echo '<li class=\'download-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>'.$row['description'].'</p>';
                echo '<a id="'.$id.'" href="material/'.$row['pic'].'" bookid="'.$row['bid'].'" download>Download</a>';
                echo '</div></div></li>';
            }
        }
    } else {
        echo "<error>No results found!</error>";
    }
    $conn->close();
?>
