<?php
    include 'session.php';
    session_start();
    $_isLoggedin=false;
    if(isset($_SESSION['user'])) {
        $_isLoggedin=true;
    }
    $_redirect="";
    if(isset($_REQUEST['redirect']) && $_REQUEST['redirect']==='login') {
        $_redirect="showAuthBox";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>U Book Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="main.css"> -->
        <link rel="stylesheet" href="cleanMain.css?token=<?php echo time(); ?>">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600|Roboto:400,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="w3.css"> -->
    </head>
    <body>
        <div id="wrap">
            <?php include 'header.php'; ?>
            <div id="main-slider">
                <img class="mySlides selectedSlide" src="back0.jpg" style="width:100%">
                <img class="mySlides" src="back1.jpg" style="width:100%">
                <img class="mySlides" src="back2.jpg" style="width:100%">
                <img class="mySlides" src="back0.jpg" style="width:100%">
                <img class="mySlides" src="back1.jpg" style="width:100%">
            </div>
            <div id="slider-wrap">
                <div id="slider">
                    <p>Recently added books</p>
                    <div id="book-slider-wrap">
                        <ul id="book-slider">
                            <?php
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
                                            echo '<li class=\'book-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>Rs. '.$row['price'].'</p><button id="addToCart">'.$text.'</button></div></div></li>';
                                        } else {
                                            echo '<li class=\'book-slide\' id="'.$row['bid'].'"><img src="uploads/'.$row['pic'].'" alt=""><div><div><h6>'.$row['name'].'</h6><p>Rs. '.$row['price'].'</p><button id="addToCart">Add to cart</button></div></div></li>';
                                        }
                                    }
                                }
                                $conn->close();
                            ?>
                        </ul>
                    </div>
                    <button class="slider-nav-btn" onclick="bookSlider('left')" id="slider-nav-left"><i class='fas fa-angle-left'></i></button>
                    <button class="slider-nav-btn" onclick="bookSlider('right')" id="slider-nav-right"><i class='fas fa-angle-right'></i></button>
                </div>
            </div>
            <div id="donate-wrap">
                <div id="donate">
                    <p>Want to donate books?</p><button onclick="location.href='/dashboard.php?action=donate'">Donate now</button>
                </div>
            </div>
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
                            <i class="fab fa-facebook-square" onclick="location.href='https://www.facebook.com/'"></i>
                            <i class="fab fa-twitter-square"  onclick="location.href=''"></i>
                            <i class="fab fa-instagram"  onclick="location.href='https://www.instagram.com/'"></i>
                            <i class="fab fa-google-plus-square"  onclick="location.href=''"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                if(!$_isLoggedin)
                    echo '<div id="userauth-wrap" class="'.$_redirect.'">
                <form id="userauth" action="auth.php" method="post">
                    <div><p id="loginTabBtn" onclick="toggleLogin(\'login\')" class="selected">Login</p><p id="signupTabBtn" onclick="toggleLogin(\'signup\')">Register</p></div>
                    <input style="display:none" id="form_type" name="type" value="login" type="text">
                    <input id="form_fullname" name="fullname" class="signupField" style="display:none" type="text" placeholder="Full Name">
                    <input id="form_phone" name="phone" class="signupField" style="display:none" type="text" placeholder="Phone Number">
                    <input id="form_email" name="email" type="email" placeholder="Email Id">
                    <input id="form_password" name="password" type="password" placeholder="Password">
                    <button>Submit</button>
                    <span id="closeBtn" onclick="hideAuthBox()"><i class=\'fas fa-close\'></i></span>
                </form>
            </div>';
            ?>
            </div>
        </div>
    </body>
    <script>
        var searchSlides=document.getElementsByClassName("search-book");
        document.addEventListener('click', function(event) {
            if(event.target.id==="addToCart") {
                var xhttp = new XMLHttpRequest();
                var temp=event.target.parentElement.parentElement.parentElement;
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText==="removed") {
                            event.target.textContent="Add to cart";
                        } else if(this.responseText==="added") {
                            event.target.textContent="Added to cart";
                        } else {
                            alert("Something went wrong.");
                        }
                        <?php
                            if($_isLoggedin) {
                                echo '       var xhttp1 = new XMLHttpRequest();
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
                xhttp.send("bid="+temp.id);
            }
        }, false);
        var myIndex = 0;
        var loginSelected=true;
        mainSlider();
        bookSlider();
        function toggleLogin(par) {
            if(par==="login")
                document.getElementById("form_type").value="login";
            else
                document.getElementById("form_type").value="signup";
            if(par==="login") {
                loginSelected=true;
                document.getElementById('loginTabBtn').className="selected";
                document.getElementById('signupTabBtn').className="";
                var fields=document.getElementsByClassName("signupField");
                for(var x in fields) {
                    fields[x].style.display="none";
                }
                bookSlider();
            } else {
                loginSelected=false;
                document.getElementById('loginTabBtn').className="";
                document.getElementById('signupTabBtn').className="selected";
                var fields=document.getElementsByClassName("signupField");
                for(var x in fields) {
                    fields[x].style.display="block";
                }
                bookSlider();
            }
        }
        function mainSlider() {
            var x=document.getElementsByClassName('mySlides');
            var index=1;
            var toggle=0;
            setInterval(function() {
                if(toggle) {
                    if(index!==5)
                        x[index].className="mySlides";
                    index-=1;
                } else {
                    x[index].className="mySlides selectedSlide";
                    index+=1;
                }
                if(index===5)
                    toggle=1;
                else if(index===0)
                    toggle=0;
            },5000);
        }
        function bookSlider(direction) {
            var x = document.getElementById("book-slider");
            var list=x.getElementsByClassName('book-slide');
            if(direction==="right") {
                var temp=list[0];
                temp.className="book-slide hideSlide";
                setTimeout(function() {
                    list[0].remove();
                    x.append(temp);
                    temp.className="book-slide";
                },400,false);
            } else {
                var temp=list[list.length-1];
                temp.className="book-slide hideSlide";
                setTimeout(function() {
                    list[list.length-1].remove();
                    x.prepend(temp);
                    temp.className="book-slide";
                },400,false);
            }
        }
        function showAuthBox() {
            document.getElementById("userauth-wrap").className="showAuthBox";
        }
        function hideAuthBox() {
            document.getElementById("userauth-wrap").className="";
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
