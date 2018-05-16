<?php
    include 'session.php';
    session_start();
    if(isset($_POST['search'])) {
        $sql="select bid,seller,author,name,description,price,pic from books where name like \"%".$_POST['search']."%\" and type='book'";
        $result=$conn->query($sql) or die("Failed");
        if($result->num_rows > 0) {
            while($row=$result->fetch_assoc()) {
                $text="Add to cart";
                $disabled="";
                if(isset($_SESSION['user'])) {
                    $sql1="select bid,uid from cart where bid=".$row['bid']." and uid=".$_SESSION['user'];
                    $result1 = $conn->query($sql1);
                    if ($result1->num_rows > 0) {
                        $text="Added to cart";
                        $disabled="disabled";
                    }
                    echo '<li class=\'search-book\' id="'.$row['bid'].'" onclick="searchBook(event)"><img id="'.$row['bid'].'" src="uploads/'.$row['pic'].'" alt=""><div id="'.$row['bid'].'"><div id="'.$row['bid'].'"><h6 id="'.$row['bid'].'">'.$row['name'].'</h6><p id="'.$row['bid'].'">Rs. '.$row['price'].'</p><button id="addToCart" bookid="'.$row['bid'].'">'.$text.'</button></div></div></li>';
                } else {
                    echo '<li class=\'search-book\' id="'.$row['bid'].'" onclick="searchBook(event)"><img id="'.$row['bid'].'" src="uploads/'.$row['pic'].'" alt=""><div id="'.$row['bid'].'"><div id="'.$row['bid'].'"><h6 id="'.$row['bid'].'">'.$row['name'].'</h6><p id="'.$row['bid'].'">Rs. '.$row['price'].'</p><button id="addToCart" bookid="'.$row['bid'].'">Add to cart</button></div></div></li>';
                }
            }
        }
    }
    $conn->close();
?>
