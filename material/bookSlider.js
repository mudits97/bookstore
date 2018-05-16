<script>
    var bookSlides=document.getElementsByClassName("book-slide");
    for (var i = 0; i < bookSlides.length; i++) {
        bookSlides[i].addEventListener('click', function(event) {
            var xhttp = new XMLHttpRequest();
            var temp=this;
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText==="removed") {
                        temp.children[1].children[0].children[2].textContent="Add to cart";
                    } else if(this.responseText==="added") {
                        temp.children[1].children[0].children[2].textContent="Added to cart";
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
            xhttp.send("bid="+this.id);
        }, false);
    }
    </script>
