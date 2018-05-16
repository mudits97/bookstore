<?php
    include 'session.php';
    session_start();
    $_isLoggedin=false;
    if(isset($_SESSION['user'])) {
        $_isLoggedin=true;
    }
    if(!isset($_SESSION['user'])) {
        header('Location: /?redirect=login');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="dashboard.css?token=<?php echo time(); ?>">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600|Roboto:400,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div id="wrap">
            <?php
                include 'header.php';
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="buy") {
                    echo '
                    <div id="book-slider-wrap" class="section-container">
                    <ul id="book-slider">
                        <p>Buy latest arrivals</p>';
                            $sql="select bid,name,author,pic,price from books where type='book'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $text="Add to cart";
                                    $disabled="";
                                    if($_isLoggedin) {
                                        $sql1="select bid,uid from cart where bid=".$row['bid']." and uid=".$_SESSION['user'];
                                        $result1 = $conn->query($sql1);
                                        if ($result1->num_rows > 0) {
                                            $text="Added to cart";
                                            $disabled="disabled";
                                        }
                                    } else {
                                        echo '<li class=\'book-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>Rs. '.$row['price'].'</p><button id="addToCart" bookid="'.$row['bid'].'">Add to cart</button></div></div></li>';
                                    }
                                    echo '<li class=\'book-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>Rs. '.$row['price'].'</p><button id="addToCart" bookid="'.$row['bid'].'">'.$text.'</button></div></div></li>';
                                }
                            }
                            $conn->close();
                    echo '</ul></div>';
                }
                if(isset($_REQUEST['action']) && ($_REQUEST['action']==="sell" || $_REQUEST['action']==="donate")) {
                    if(isset($_SESSION['address']) && trim($_SESSION['address'])!=="") {
                        echo '<div id="book-sell-donate-wrap" class="section-container">
                            <div id="book-sell-donate"><p>'.ucfirst($_REQUEST['action']).' books</p>
                                <img id="preview_image" src="" alt="Upload pic">
                                <form action="uploads.php" method="post" enctype="multipart/form-data">
                                    <input type="text" name="bookName" id="bookName" placeholder="Book name">';
                                    if($_REQUEST['action']!=='sell')
                                    echo '<input type="text" name="bookPrice" id="bookPrice" placeholder="Book price" style="display:none" value="0">';
                                    else
                                    echo '<input type="text" name="bookPrice" id="bookPrice" placeholder="Book price">';
                                    echo'
                                    <input type="text" name="bookAuthor" id="bookAuthor" placeholder="Book author">
                                    <textarea name="bookDescription" id="bookDescription" placeholder="Book description" rows="4"></textarea>
                                    <span style="margin-top:20px;">Category:</span>
                                    <select name="degree">
                                    ';
                                    $sql="select distinct(degree) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['degree'].'">'.$row['degree'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <select name="branch">
                                    ';
                                    $sql="select distinct(branch) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['branch'].'">'.$row['branch'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <select name="semester">
                                    ';
                                    $sql="select distinct(sem) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['sem'].'">'.$row['sem'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <span>Select image to upload:</span>
                                    <input type="file" name="fileToUpload" id="fileToUpload" onchange="preview_image(event)">
                                    <input type="submit" value="';
									echo ucfirst($_REQUEST['action']);
									echo ' book" name="submit">
                                </form>
                            </div>
                        </div>';
                    } else {
                        echo '<script>location.href="/dashboard.php?action=profile&redirect=true";</script>';
                    }
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="cart") {
                    echo '<div id="cart-wrap" class="section-container"><div id="cart">
                        <p>Cart details</p>
                        <ul>';
                            $sql="SELECT cid,uid,c.bid as cbid,date,name,author,b.bid,seller,description,price,pic FROM `cart` as c,books as b WHERE c.bid=b.bid and uid=".$_SESSION['user'];
                            $result=$conn->query($sql) or die("failed | ".$conn->error);
                            if($result->num_rows>0) {
                                while($row=$result->fetch_assoc()) {
                                    echo '<li onclick="removeFromCart(event)" class="cart-slide" bid="'.$row['bid'].'"><img bid="'.$row['bid'].'" src="uploads/'.$row['pic'].'" alt="Book cover"><div bid="'.$row['bid'].'" style="max-width:250px !important;display:inline-block"><h6 bid="'.$row['bid'].'">Name: <b bid="'.$row['bid'].'">'.$row['name'].'</b></h6><p bid="'.$row['bid'].'">Author: <b bid="'.$row['bid'].'">'.$row['author'].'</b></p><p bid="'.$row['bid'].'">Price: <b bid="'.$row['bid'].'">Rs. '.$row['price'].'</b></p><button id="removeFromCart" bookid="'.$row['cbid'].'">Remove from cart</button></div></li>';
                                }
                            } else {
                                echo "<h4>No results found.</h4>";
                            }
                            echo'
                        </ul>
                    </div></div>';
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="search") {
                    echo '<div id="book-details-wrap" class="section-container">
                        <div id="book-details">
                            <p>Book details</p>';
                                if(isset($_REQUEST['book'])) {
                                    $sql="SELECT bid,name,author,price,seller,pic,description,fullname,email,phone FROM `books` as b,users as u  WHERE bid=".$_REQUEST['book']." and seller=id";
                                    $result=$conn->query($sql);
                                    if($result->num_rows > 0) {
                                        while($row=$result->fetch_assoc()) {
                                            $text="Add to cart";
                                            $sql1="select bid,uid,status from cart where bid=".$row['bid']." and uid=".$_SESSION['user'];
                                            $result1 = $conn->query($sql1);
                                            if ($result1->num_rows > 0) {
                                                $text="Added to cart";
                                            }
                                            echo '
                                            <img src="uploads/'.$row['pic'].'" alt="Book cover">
                                            <div>
                                                <h5>'.$row['name'].'</h5>
                                                <p>Author: <b>'.$row['author'].'</b></p>
                                                <p>Price : Rs. <b>'.$row['price'].'</b></p>
                                                ';
                                                $seller=0;
                                                $sql1="select bid,uid,status from cart where bid=".$row['bid']." and status=1 and uid=".$_SESSION['user'];
                                                $result1 = $conn->query($sql1);
                                                if ($result1->num_rows > 0) {
                                                    echo '<p>Seller: '.$row['fullname'].'</p>
                                                    <p>Seller\'s phone: '.$row['phone'].'</p>
                                                    <p>Seller\'s email: '.$row['email'].'</p>';
                                                    $seller=1;
                                                }
                                                echo '
                                                <p>Description:<span><b>'.$row['description'].'</b></span></p>
                                                <button bookid="'.$row['bid'].'" id="addToCart">'.$text.'</button>';
                                                if($seller===0)
                                                echo '
                                                <p>* Seller details will be disclosed once the seller has accepted your book request.</p>
                                            </div>';
                                        }
                                    } else {
                                        echo "<h4>No such book found</h4>";
                                    }
                                }
                                echo '</div></div>';
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="category") {
                    echo '<div class="section-container"><div id="category-list-wrap">';
                    $class='book-slide';
                    $id="addToCart";
                    $check=false;
                    if($_REQUEST['type']==="readingmaterial" || $_REQUEST['type']==="programmingcodes" || $_REQUEST['type']==="questionpapers") {
                        echo '<button id="uploadNewContent" onclick="location.href=\'/dashboard.php?action=upload&type='.$_REQUEST['type'].'\'">Upload new content</button>';
                        $class='download-slide';
                        $id="downloadFile";
                        $check=true;
                    }
                    echo '<section id="category-book-filter">
                                <p>Filters</p>
                                <ul>
                                    <li>
                                        <span>Degree</span>
                                        <select name="category" id="degreeSelect">
                                            <option name="category" value="None">None</option>
                                        ';
                                        $sql="select distinct(degree) from categories";
                                        $result=$conn->query($sql);
                                        if($result->num_rows>0) {
                                            while($row=$result->fetch_assoc()) {
                                                echo '<option name="category" value="'.$row['degree'].'">'.$row['degree'].'</option>';
                                            }
                                        }
                                        echo'
                                        </select>
                                    </li>
                                    <li>
                                        <span>Branch</span>
                                        <select name="branch" id="branchSelect">
                                            <option name="category" value="None">None</option>
                                        ';
                                        $sql="select distinct(branch) from categories";
                                        $result=$conn->query($sql);
                                        if($result->num_rows>0) {
                                            while($row=$result->fetch_assoc()) {
                                                echo '<option name="category" value="'.$row['branch'].'">'.$row['branch'].'</option>';
                                            }
                                        }
                                        echo'
                                        </select>
                                    </li>
                                    <li>
                                        <span>Semester</span>
                                        <select name="semester" id="semesterSelect">
                                            <option name="category" value="None">None</option>
                                        ';
                                        $sql="select distinct(sem) from categories";
                                        $result=$conn->query($sql);
                                        if($result->num_rows>0) {
                                            while($row=$result->fetch_assoc()) {
                                                echo '<option name="category" value="'.$row['sem'].'">'.$row['sem'].'</option>';
                                            }
                                        }
                                        echo'
                                        </select>
                                    </li>
                                </ul>
                                <button onclick="getCategory()">Apply</button>
                            </section>';
                    echo '<div id="category-list"><p>';
					if($_REQUEST['type']==="readingmaterial")
						echo "Reading Material";
					else if($_REQUEST['type']==="programmingcodes")
						echo "Programming Codes";
					else if($_REQUEST['type']==="questionpapers")
						echo "Question Papers";
					else if(isset($_REQUEST['branch']) && $_REQUEST['type']==="book")
						echo ucfirst($_REQUEST['branch']);
					else
						echo "Categories";
					echo '</p><ul id="categoryList">';

                    $temp1="%";
                    $temp2="%";
                    $temp3="%";
                    if(isset($_REQUEST['degree']))
                        $temp1=$_REQUEST['degree'];
                    if(isset($_REQUEST['branch']))
                        $temp2=$_REQUEST['branch'];
                    if(isset($_REQUEST['semester']))
                        $temp3=$_REQUEST['semester'];
				
					
                    if($_REQUEST['type']==="book")
                        $sql="SELECT allowed,bid,name,author,price,seller,pic,description,fullname,email,phone FROM `books` as b,users as u  WHERE degree like '".$temp1."' and branch like '".$temp2."' and sem like '".$temp3."' and  seller=id and type='".$_REQUEST['type']."'";
                    else
                        $sql="SELECT allowed,bid,name,author,price,seller,pic,description,fullname,email,phone FROM `books` as b,users as u  WHERE degree like '".$temp1."' and branch like '".$temp2."' and sem like '".$temp3."' and  seller=id and type='".$_REQUEST['type']."' and allowed=1";
                    $result=$conn->query($sql);
                    if($result->num_rows>0) {
                        while($row=$result->fetch_assoc()) {
                            $text="Add to cart";
                            if($_REQUEST['type']!=="book") {
                                $text="Download";
                            }
                            $disabled="";
                            if($text!=="Download" && $_isLoggedin) {
                                $sql1="select bid,uid from cart where bid=".$row['bid'];
                                $result1 = $conn->query($sql1);
                                if ($result1->num_rows > 0) {
                                    $text="Added to cart";
                                    $disabled="disabled";
                                }
                                echo '<li class=\''.$class.'\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>';
                                if($check)
                                echo $row['description'];
                                else echo
                                'Rs. '.$row['price'];echo '</p>';
                                if(!$check)
                                echo '<button id="'.$id.'" bookid="'.$row['bid'].'">'.$text.'</button>';
                                else
                                echo '<a id="'.$id.'" href="material/'.$row['pic'].'" bookid="'.$row['bid'].'" download>'.$text.'</a>';
                                echo'</div></div></li>';
                            } else {
                                echo '<li class=\''.$class.'\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>';
                                if($check)
                                echo $row['description'];
                                else echo
                                'Rs. '.$row['price']; echo '</p>';
                                if(!$check)
                                echo '<button id="'.$id.'" bookid="'.$row['bid'].'">'.$text.'</button>';
                                else
                                echo '<a id="'.$id.'" href="material/'.$row['pic'].'" bookid="'.$row['bid'].'" download>'.$text.'</a>';
                                echo'</div></div></li>';
                            }
                        }
                    } else {
                        echo "<error>No results found!</error>";
                    }
                    echo '</ul></div></div></div>';
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="profile") {
                    if(isset($_REQUEST['redirect']) && $_REQUEST['redirect']==="true") {
                        echo '<div id="profile-completion-warning">Complete your profile in order to sell/donate books.</div>';
                    }
                    echo '<div class="section-container" id="profile-wrap"><div id="profile"><p>Profile</p><img id="preview_image" src="profile/'.$_SESSION['user'].'.jpg" alt="Upload pic">
                    <form action="uploadsProfile.php" method="post" enctype="multipart/form-data">';
                    $sql="select fullName,address,phone,email from users where id=".$_SESSION['user'];
                    $result=$conn->query($sql) or die("error | ".$conn->error);
                    if($result->num_rows>0) {
                        while($row=$result->fetch_assoc()) {
                            echo '
                            <input type="text" name="userName" id="bookName" placeholder="Full Name" value="'.$row['fullName'].'">
                            <input type="text" name="userEmail" id="bookPrice" placeholder="Email Id" value="'.$row['email'].'" disabled>
                            <input type="text" name="userPhone" id="bookAuthor" placeholder="Phone Number" value="'.$row['phone'].'">
                            <textarea name="userAddress" id="userAddress" placeholder="Address" rows="4">'.$row['address'].'</textarea>
                            ';
                        }
                    }
                        echo '<span>Select image to upload:</span>
                        <input type="file" name="fileToUpload" id="fileToUpload" onchange="preview_image(event)">
                        <input type="submit" value="Update Profile" name="submit">
                    </form></div></div>';
                    }
					
					
					// Request book from the seller.
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="requests") {
                    echo '
                    <div class="section-container" id="requests-wrap">
                        <div id="requests">
                            <p>Requests</p>
                            <ul>';
                            $sql="SELECT c.bid,cid,c.date,c.uid,b.name,b.author,b.price,seller,id,fullname,email,phone,address,b.pic,description FROM cart as c,books as b,users WHERE status=0 and b.bid=c.bid and seller=id and id=".$_SESSION['user']; 
                            $result=$conn->query($sql);
                            if($result->num_rows>0) {
                                while($row=$result->fetch_assoc()) {
                                    echo '<li cid="'.$row['cid'].'" uid="'.$row['uid'].'"><img src="/uploads/'.$row['pic'].'" alt="Book cover"><div><h6>Book Name: <b>'.$row['name'].'</b></h6><p>Price: <b>Rs. '.$row['price'].'</b></p><p>Author: <b>'.$row['author'].'</b></p><p>Desciption: <b>'.$row['description'].'</b></p><section><button style="background-image:unset;background-color:#e00" id="acceptRequest">Accept</button><button id="rejectRequest" style="background-image:unset;background-color:#0a0">Reject</button></section></div></li>';
                                }
                            } else {
                                echo "No results found.";
                            }
                            echo '
                            </ul>
                        </div>
                    </div>';
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="notifications") {
                    echo '
                    <div class="section-container" id="notifications-wrap">
                        <div id="notifications">
                            <p>Notifications</p>
                            <ul>';
                            $sql="select msg,nid from notifications where uid=".$_SESSION['user'];
                            $result=$conn->query($sql);
                            if($result->num_rows>0) {
                                while($row=$result->fetch_assoc()) {
                                    if(strpos($row['msg'],"rejected") > 0)
                                    echo '<li class="neg">'.$row['msg'].'</li>';
                                    else {
                                        echo '<li>'
                                        .$row['msg'].'</li>';
                                    }
                                }
                            } else {
                                echo "No results found.";
                            }
                            echo '
                            </ul>
                        </div>
                    </div>';
                }
				
				// Upload contents.
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="upload") {
                        echo '<div id="book-sell-donate-wrap" class="section-container">
                            <div id="book-sell-donate"><p>'.ucfirst($_REQUEST['action']).' books</p>
                                <img id="preview_image" src="" alt="Upload pic" style="display:none">
                                <form action="uploadsMaterial.php" method="post" enctype="multipart/form-data">
                                    <input type="text" name="type" value="'.$_REQUEST['type'].'" style="display:none">
                                    <input type="text" name="fileName" id="fileName" placeholder="File name">
                                    <textarea name="fileDescription" id="fileDescription" placeholder="File description" rows="4"></textarea>
                                    <span style="margin-top:20px;">Category:</span>
                                    <select name="degree">
                                    ';
                                    $sql="select distinct(degree) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['degree'].'">'.$row['degree'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <select name="branch">
                                    ';
                                    $sql="select distinct(branch) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['branch'].'">'.$row['branch'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <select name="semester">
                                    ';
                                    $sql="select distinct(sem) from categories";
                                    $result=$conn->query($sql);
                                    if($result->num_rows>0) {
                                        while($row=$result->fetch_assoc()) {
                                            echo '<option name="category" value="'.$row['sem'].'">'.$row['sem'].'</option>';
                                        }
                                    }
                                    echo'
                                    </select>
                                    <span>Select file to upload:</span>
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                    <input type="submit" value="Sell book" name="submit">
                                </form>
                            </div>
                        </div>';
                }
                if(isset($_REQUEST['action']) && $_REQUEST['action']==="uploadrequests") {
                    echo "<div class='section-container' id='uploadrequests-wrap'><div><p>Upload Requests</p>";
                    $sql="SELECT rid,r.bid,uid,fullname,email,time,name,description,pic FROM `requests` as r,books as b,users WHERE uid=id and r.bid=b.bid";
                    $result=$conn->query($sql);
                    if($result->num_rows > 0) {
                        while($row=$result->fetch_assoc()) {
                            echo '<div bid="'.$row['bid'].'" cid="'.$row['rid'].'" uid="'.$row['uid'].'"><div><h6>File Name: <b>'.$row['name'].'</b></h6><p>Description: <b>'.$row['description'].'</b></p><p>Author: <b>'.$row['fullname'].'</b></p><section><button style="background-image:unset;background-color:#0a0" id="acceptRequest">Accept</button><button id="rejectRequest" style="background-image:unset;background-color:#e00">Reject</button><a href="material/'.$row['pic'].'" download>Click here to download</a></section></div></div>';
                        }
                    } else {
                        echo "<error>No results found!</error>";
                    }
                    echo "</div></div>";
                }
            ?>
            <div id="footer-wrap">
                <div id="footer">
                    <div>
                        <div>
                            <section>
                                <img src="book.png" alt="Logo">
                                <p>UBookStore</p>
                            </section>
                            <div>
                                <div id="footer-links">
                                    <p onclick="location.href='terms.php'">Terms and Conditions</p>
                                    <p onclick="location.href='aboutus.php'">About Us</p>
                                </div>
                                <div id="footer-subscribe">
                                    <input type="text" id="subscribe_email" placeholder="Enter your email id.">
                                    <button onclick="subscribe()">Subscribe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Copyright &copy; 2018 UBookStore</p>
                        <div id="footer-follow">
                            <span>Follow us on:</span>
                            <i class="fab fa-facebook-square" onclick="location.href=''"></i>
                            <i class="fab fa-twitter-square"  onclick="location.href=''"></i>
                            <i class="fab fa-instagram"  onclick="location.href=''"></i>
                            <i class="fab fa-google-plus-square"  onclick="location.href=''"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        var bookSlides=document.getElementsByClassName("book-slide");
        document.addEventListener("click",function(event) {
            if(event.target.id==="acceptRequest") {
                <?php
                    if($_REQUEST['action']==="uploadrequests") {
                        echo 'var xhttp = new XMLHttpRequest();
                        var parent=event.target.parentElement.parentElement.parentElement;
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                if(this.responseText==="success") {
                                    parent.remove();
                                } else {
                                    alert("Something went wrong.");
                                }
                            }
                        };
                        xhttp.open("POST", "allowRequest.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("action=accept&rid="+parent.attributes.cid.nodeValue+"&bid="+parent.attributes.bid.nodeValue+"&uid="+parent.attributes.uid.nodeValue);';
                    } else {
                        echo 'var xhttp = new XMLHttpRequest();
                        var parent=event.target.parentElement.parentElement.parentElement;
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                if(this.responseText==="success") {
                                    parent.remove();
                                } else {
                                    alert("Something went wrong.");
                                }
                            }
                        };
                        xhttp.open("POST", "notify.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("action=accept&id="+parent.attributes.cid.nodeValue+"&msg=Your request for purchase of book, <b>"+parent.querySelector(\'h6\').textContent.split(":")[1]+"</b> was accepted by "+"'.$_SESSION['fullname'].'&uid="+parent.attributes.uid.nodeValue);';
                    }
                ?>
            } else if(event.target.id==="rejectRequest") {
                <?php
                    if($_REQUEST['action']==="uploadrequests") {
                        echo 'var xhttp = new XMLHttpRequest();
                        var parent=event.target.parentElement.parentElement.parentElement;
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                if(this.responseText==="success") {
                                    parent.remove();
                                } else {
                                    alert("Something went wrong.");
                                }
                            }
                        };
                        xhttp.open("POST", "allowRequest.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("action=reject&rid="+parent.attributes.cid.nodeValue+"&bid="+parent.attributes.bid.nodeValue+"&uid="+parent.attributes.uid.nodeValue);';
                    } else {
                        echo 'var xhttp = new XMLHttpRequest();
                        var parent=event.target.parentElement.parentElement.parentElement;
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                if(this.responseText==="success") {
                                    parent.remove();
                                } else {
                                    alert("Something went wrong.");
                                }
                            }
                        };
                        xhttp.open("POST", "notify.php", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhttp.send("action=reject&id="+parent.attributes.cid.nodeValue+"&msg=Your request for purchase of book, <b>"+parent.querySelector(\'h6\').textContent.split(":")[1]+"</b> was rejected by "+"'.$_SESSION['fullname'].'&uid="+parent.attributes.uid.nodeValue);';

                    }
                 ?>
            } else if(event.target.id==="addToCart") {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText==="removed") {
                            <?php
                                if($_REQUEST['action']==='cart') {
                                    echo 'event.target.parentElement.parentElement.remove();';
                                }
                            ?>
                            event.target.textContent="Add to cart";
                        } else if(this.responseText==="added") {
                            event.target.textContent="Added to cart";
                        } else {
                            alert("Something went wrong.");
                        }
                        <?php
                            if($_isLoggedin) {
                                echo 'var xhttp1 = new XMLHttpRequest();
                                xhttp1.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("header-cart-count").textContent=this.responseText;
                                    }
                                };
                                xhttp1.open("GET", "countBooks.php", true);
                                xhttp1.send();';
                            }
                        ?>
                    }
                };
                xhttp.open("POST", "addtocart.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("bid="+event.target.attributes.bookid.nodeValue);
            } else if(event.target.parentElement.className==="book-slide") {
                location.href="/dashboard.php?action=search&book="+event.target.parentElement.id;
            }
        });
		function searchBook(event) {
			if(event.target.tagName!=="BUTTON")
				location.href="/dashboard.php?action=search&book="+event.target.parentElement.id;
		}
        function removeFromCart(event) {
            if(event.target.tagName==="BUTTON") {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText==="removed") {
                            <?php
                                if($_REQUEST['action']==='cart') {
                                    echo 'event.target.parentElement.parentElement.remove();';
                                }
                            ?>
                            event.target.textContent="Add to cart";
                        } else if(this.responseText==="added") {
                            event.target.textContent="Added to cart";
                        } else {
                            alert("Something went wrong.");
                        }
                        <?php
                            if($_isLoggedin) {
                                echo 'var xhttp1 = new XMLHttpRequest();
                                xhttp1.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("header-cart-count").textContent=this.responseText;
                                    }
                                };
                                xhttp1.open("GET", "countBooks.php", true);
                                xhttp1.send();';
                            }
                        ?>
                    }
                };
                xhttp.open("POST", "addtocart.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("bid="+event.target.attributes.bookid.nodeValue);
            } else {
                location.href="/dashboard.php?action=search&book="+event.target.attributes.bid.nodeValue;
            }
        }
        <?php
        if(isset($_REQUEST['book'])) {
            echo 'function addToCartFunc(event) {
                var xhttp = new XMLHttpRequest();
                var temp=event.target;
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText==="removed") {
                            temp.textContent="Add to cart";
                        } else if(this.responseText==="added") {
                            temp.textContent="Added to cart";
                        } else {
                            alert("Something went wrong.");
                        }';
                            if($_isLoggedin) {
                                echo 'var xhttp1 = new XMLHttpRequest();
                                xhttp1.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("header-cart-count").textContent=this.responseText;
                                    }
                                };
                                xhttp1.open("GET", "countBooks.php", true);
                                xhttp1.send();';
                            }
                echo '}
                };
                xhttp.open("POST", "addtocart.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("bid="+ "'.$_REQUEST['book'].'");}';
        }
        ?>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
         }
         function getCategory() {
             var xhttp = new XMLHttpRequest();
             var categoryList=document.getElementById("categoryList");
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                     if(this.responseText==="empty") {
                         categoryList.innerHTML="<error>No books found.</error>";
                     } else {
                         categoryList.innerHTML=this.responseText;
                     }
                 }
             };
             var degree=document.getElementById("degreeSelect");
             var branch=document.getElementById("branchSelect");
             var semester=document.getElementById("semesterSelect");
             xhttp.open("POST", "getCategories.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             xhttp.send("degree="+degree.value+"&branch="+branch.value+"&semester="+semester.value+"&type="+"<?php if(isset($_REQUEST['type'])) echo $_REQUEST['type']; else echo ""; ?>");
         }
         function subscribe() {
             var xhttp = new XMLHttpRequest();
             xhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                     if(this.responseText==="success") {
                         alert("Successfully suscribed");
                     } else if(this.responseText==="already") {
                         alert("It seems that you are already subscribed.");
                     } else {
                         alert("Something went wrong.");
                     }
                 }
             };
             xhttp.open("POST", "subscribe.php", true);
             xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
             xhttp.send("email="+document.getElementById("subscribe_email").value);
         }
    </script>
</html>
