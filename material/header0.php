<!-- <link rel="stylesheet" href="header.css"> -->
<div id="header-wrap">
    <div id="header">
        <ul>
            <li>
            <button onclick="openNav()" id="mySidenav-btn">&#9776;</button></li>
            <li>Categories

                <ul>
                    <li>B.Tech.</li>
                    <li>B.Sc.</li>
                    <li>Hotel Management</li>
                    <li>Business</li>
                </ul>
            </li>
            <li onclick="location.href='/dashboard.php?action=buy'">New Arrivals</li>
            <li onclick="location.href='/dashboard.php?action=sell'">Sell</li>
            <li onclick="location.href='/dashboard.php?action=donate'">Donate</li>
        </ul>
        <p onclick="location.href='/'">UBook Store</p>
        <div id="header-member-options">
            <i onclick="showSearch()" class="fas fa-search"></i>
            <?php
                if(!$_isLoggedin)
                    echo '
            <button onclick="showAuthBox()">Login/Signup</button>
                    ';
                else {
                    echo '<i onclick="location.href=\'/dashboard.php?action=cart\'" id="header-cart-icon" class="fas fa-shopping-cart"><span id="header-cart-count"></span></i>
                    <h6>'.$_SESSION['fullname'].'</h6><a href="logout.php">Logout</a>';
                }
            ?>
        </div>
    </div>
</div>
<div id="search-wrap" style="display:none">
    <div id="search">
        <i class="fas fa-search"></i><input id="fullScreenSearch" type="text" placeholder="Start typing here.." >
        <i class="fas fa-close" onclick="closeSearch()"></i>
    </div>
    <ul id="search-result">

    </ul>
</div>
<script>
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
function showSearch() {
    document.getElementById("search-wrap").style.display="block";
}
function closeSearch() {
    document.getElementById("search-wrap").style.display="none";
}
var fullScreenSearch=document.getElementById("fullScreenSearch");
var fullScreenSearchResult=document.getElementById("search-result");
fullScreenSearch.addEventListener("change",function() {
    fullScreenSearchResult.innerHTML="";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            fullScreenSearchResult.innerHTML=this.responseText;
        }
    };
    xhttp.open("POST", "searchBook.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("search="+this.value);
});
</script>
