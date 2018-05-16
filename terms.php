<?php
    include 'session.php';
    session_start();
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
            ?>
            <div class='section-container'>
                <div id="aboutus">
                    <p>Terms and Conditions</p>
                    <article>
                        This is a demo article about our company's terms and conditions. This is just a demo.
                    </article>
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
</html>
